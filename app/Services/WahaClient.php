<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class WahaClient
{
    public function send(string $phone, string $text): array
    {
        $baseUrl = rtrim((string) config('services.waha.base_url'), '/');
        $session = (string) config('services.waha.session', 'default');
        $apiKey = (string) config('services.waha.api_key');

        if ($baseUrl === '') {
            return $this->fail('WAHA belum dikonfigurasi. Isi WAHA_BASE_URL.');
        }
        if ($session === '') {
            $session = 'default';
        }

        $digits = $this->digits($phone);
        if ($digits === null) {
            return $this->fail('Nomor WhatsApp tidak valid.');
        }

        try {
            $chatId = $this->resolveChatId($baseUrl, $session, $apiKey, $digits);
        } catch (\RuntimeException $e) {
            return $this->fail($e->getMessage());
        } catch (\Throwable $e) {
            return $this->fail('WAHA tidak dapat dihubungi.');
        }

        if ($chatId === null) {
            return $this->fail('Nomor tidak terdaftar di WhatsApp.');
        }

        try {
            $response = $this->http($apiKey)->post($baseUrl . '/api/sendText', [
                'session' => $session,
                'chatId' => $chatId,
                'text' => $text,
            ]);
        } catch (\Throwable $e) {
            return $this->fail('WAHA tidak dapat dihubungi.', $chatId);
        }

        if ($response->successful()) {
            return ['ok' => true, 'error' => null, 'chat_id' => $chatId];
        }

        return $this->fail($this->errorMessage($response), $chatId);
    }

    public function chatId(string $phone): ?string
    {
        $digits = $this->digits($phone);

        return $digits === null ? null : $digits . '@c.us';
    }

    private function resolveChatId(string $baseUrl, string $session, string $apiKey, string $digits): ?string
    {
        $response = $this->http($apiKey)->get($baseUrl . '/api/contacts/check-exists', [
            'phone' => $digits,
            'session' => $session,
        ]);

        if (!$response->successful()) {
            throw new \RuntimeException($this->errorMessage($response));
        }

        if ($response->json('numberExists') === false) {
            return null;
        }

        $chatId = $response->json('chatId');
        if (is_string($chatId) && $chatId !== '') {
            return $chatId;
        }

        return $digits . '@c.us';
    }

    private function http(string $apiKey)
    {
        $request = Http::timeout(20)
            ->withOptions([
                'connect_timeout' => 5,
                'proxy' => '',
            ])
            ->acceptJson();

        if ($apiKey !== '') {
            $request = $request->withHeaders(['X-Api-Key' => $apiKey]);
        }

        return $request;
    }

    private function digits(string $phone): ?string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';
        if ($digits === '') {
            return null;
        }
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        } elseif (!str_starts_with($digits, '62')) {
            $digits = '62' . $digits;
        }
        if (strlen($digits) < 10 || strlen($digits) > 15) {
            return null;
        }

        return $digits;
    }

    private function errorMessage(Response $response): string
    {
        $message = $response->json('exception.message')
            ?? $response->json('message')
            ?? $response->json('error');

        if (is_array($message)) {
            $message = $message['message'] ?? json_encode($message);
        }
        if (is_string($message) && $message !== '') {
            $line = trim(strtok($message, "\n"));
            if ($line !== '') {
                return $line;
            }
        }

        $body = trim($response->body());
        if ($body !== '' && !str_starts_with($body, '<') && strlen($body) <= 180) {
            $line = trim(strtok($body, "\n"));
            if ($line !== '') {
                return $line;
            }
        }

        return 'WAHA menolak permintaan (HTTP ' . $response->status() . ').';
    }

    private function fail(string $error, ?string $chatId = null): array
    {
        return ['ok' => false, 'error' => $error, 'chat_id' => $chatId];
    }
}

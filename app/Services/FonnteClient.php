<?php

namespace App\Services;

use App\Support\NomorWhatsapp;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class FonnteClient
{
    public function send(string $phone, string $text): array
    {
        $token = (string) config('services.fonnte.token');
        if ($token === '') {
            return $this->fail('Pengiriman WhatsApp belum dikonfigurasi.');
        }

        try {
            $target = NomorWhatsapp::normalize($phone);
        } catch (InvalidArgumentException $e) {
            return $this->fail($e->getMessage());
        }

        if ($target === null) {
            return $this->fail(NomorWhatsapp::PESAN);
        }

        try {
            $response = Http::timeout(20)
                ->withOptions([
                    'connect_timeout' => 5,
                    'proxy' => '',
                ])
                ->withHeaders([
                    'Authorization' => $token,
                ])
                ->asForm()
                ->post('https://api.fonnte.com/send', [
                    'target' => $target,
                    'message' => $text,
                ]);
        } catch (\Throwable $e) {
            return $this->fail('Fonnte tidak dapat dihubungi.');
        }

        $status = $response->json('status');
        if ($response->successful() && ($status === true || $status === 1 || $status === 'true')) {
            return ['ok' => true, 'error' => null];
        }

        return $this->fail($this->safeReason($response, $token));
    }

    private function safeReason(Response $response, string $token): string
    {
        $reason = $response->json('reason')
            ?? $response->json('detail')
            ?? $response->json('message');

        if (is_array($reason)) {
            $reason = $reason['message'] ?? '';
        }

        $reason = is_string($reason) ? trim($reason) : '';
        if ($token !== '' && $reason !== '') {
            $reason = str_replace($token, '', $reason);
            $reason = trim($reason);
        }

        if ($reason === '' || strlen($reason) > 180 || stripos($reason, 'authorization') !== false) {
            return 'Fonnte menolak permintaan.';
        }

        return $reason;
    }

    private function fail(string $error): array
    {
        return ['ok' => false, 'error' => $error];
    }
}

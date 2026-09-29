<?php

namespace App\Support;

use InvalidArgumentException;

class NomorWhatsapp
{
    public const PESAN = 'Nomor WhatsApp harus diawali 08 atau 628.';

    public static function normalize(?string $value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        $digits = preg_replace('/[\s.\-]/', '', $value) ?? '';
        if (!preg_match('/^(08\d{8,12}|628\d{8,12})$/', $digits)) {
            throw new InvalidArgumentException(self::PESAN);
        }

        if (str_starts_with($digits, '08')) {
            $digits = '62' . substr($digits, 1);
        }

        return $digits;
    }
}

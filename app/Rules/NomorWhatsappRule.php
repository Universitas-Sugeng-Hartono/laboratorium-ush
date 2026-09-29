<?php

namespace App\Rules;

use App\Support\NomorWhatsapp;
use Illuminate\Contracts\Validation\Rule;
use InvalidArgumentException;

class NomorWhatsappRule implements Rule
{
    public function passes($attribute, $value)
    {
        if ($value === null || trim((string) $value) === '') {
            return true;
        }

        try {
            NomorWhatsapp::normalize($value);
            return true;
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    public function message()
    {
        return NomorWhatsapp::PESAN;
    }
}

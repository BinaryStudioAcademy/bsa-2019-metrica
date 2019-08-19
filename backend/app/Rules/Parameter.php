<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

final class Parameter implements Rule
{
    private const AVAILABLE_PARAMETERS = [
        'language',
        'country',
        'city',
        'browser',
        'operating_system',
        'screen_resolution'
    ];

    public function passes($attribute, $value): bool
    {
        return in_array($value, self::AVAILABLE_PARAMETERS);
    }

    public function message(): string
    {
        return 'The :attribute must be one of available parameters.';
    }
}

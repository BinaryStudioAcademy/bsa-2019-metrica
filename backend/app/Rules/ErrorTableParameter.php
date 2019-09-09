<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

final class ErrorTableParameter implements Rule
{
    private const AVAILABLE_PARAMETER = 'page';

    public function passes($attribute, $value): bool
    {
        return $value === self::AVAILABLE_PARAMETER;
    }

    public function message(): string
    {
        return 'The :attribute must be one of available parameters.';
    }
}
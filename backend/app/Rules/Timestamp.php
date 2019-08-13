<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

final class Timestamp implements Rule
{
    public function passes($attribute, $value): bool
    {
        return strtotime('@' . $value) !== false;
    }

    public function message(): string
    {
        return 'The :attribute is not a valid timestamp.';
    }
}

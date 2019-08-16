<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

final class TimestampAfter implements Rule
{
    private $dateBefore;

    public function __construct(string $dateBefore)
    {
        $this->dateBefore = $dateBefore;
    }

    public function passes($attribute, $value): bool
    {
        return $value > $this->dateBefore;
    }

    public function message(): string
    {
        return 'The :attribute must be a date after ' . $this->dateBefore . '.';
    }
}

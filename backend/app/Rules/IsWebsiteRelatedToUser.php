<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsWebsiteRelatedToUser implements Rule
{
    public function passes($attribute, $value)
    {
        $userWebsitesIds = auth()->user()
                                ->websites
                                ->pluck('id');

        if (!$userWebsitesIds->contains($value)) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Website not found.';
    }
}

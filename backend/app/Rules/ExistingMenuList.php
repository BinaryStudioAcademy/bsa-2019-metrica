<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExistingMenuList implements Rule
{
    public function passes($attribute, $value)
    {
        $allMenuItems = explode(', ', config('sidebar.partial_access_menu_items'));

        $requestMenuItems = explode(', ', $value);

        $intersect = array_intersect($requestMenuItems, $allMenuItems);

        if ($requestMenuItems === $intersect) {
            return true;
        }
        return false;
    }

    public function message()
    {
        return 'Menu list contain nonexistent menu items';
    }
}

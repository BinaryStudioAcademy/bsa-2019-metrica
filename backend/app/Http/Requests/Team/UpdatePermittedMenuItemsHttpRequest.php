<?php

declare(strict_types=1);

namespace App\Http\Requests\Team;

use App\Http\Request\ApiFormRequest;
use App\Rules\{IsWebsiteRelatedToUser, ExistingMenuList};
use Illuminate\Support\Collection;


final class UpdatePermittedMenuItemsHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'filter.user_ids' => [
                'required',
                'array'
            ],
            'filter.iser_ids.*' => [
                'integer',
                'exists:users,id'
            ],
            'filter.permitted_menu.*' => [
                'string',
                new ExistingMenuList()
            ],
            'filter.website_id' => [
                'required',
                'integer',
                new IsWebsiteRelatedToUser()
            ],
        ];
    }

    public function websiteId(): int
    {
        return (int)$this->get('filter')['website_id'];
    }

    public function updateList(): Collection
    {
        return new Collection(array_combine(
            $this->get('filter')['user_ids'],
            $this->get('filter')['permitted_menu']
        ));
    }
}

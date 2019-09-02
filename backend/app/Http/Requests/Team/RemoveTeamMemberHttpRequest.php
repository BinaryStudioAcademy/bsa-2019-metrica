<?php

declare(strict_types=1);

namespace App\Http\Requests\Team;

use App\Http\Request\ApiFormRequest;
use App\Rules\IsWebsiteRelatedWithUser;

final class RemoveTeamMemberHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'filter' => 'required|array',
            'filter.website_id' => [
                'required',
                'integer',
                new IsWebsiteRelatedWithUser()
            ],
        ];
    }

    public function websiteId(): int
    {
        return (int)$this->get('filter')['website_id'];
    }
}

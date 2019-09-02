<?php

declare(strict_types=1);

namespace App\Http\Requests\Team;

use App\Http\Request\ApiFormRequest;
use App\Rules\IsWebsiteRelatedWithUser;

final class InviteTeamMemberHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'filter' => 'required|array',
            'filter.email' => [
                'required',
                'email'
            ],
            'filter.website_id' => [
                'required',
                'integer',
                new IsWebsiteRelatedWithUser()
            ],
        ];
    }

    public function email(): string
    {
        return (string)$this->get('filter')['email'];
    }

    public function websiteId(): int
    {
        return (int)$this->get('filter')['website_id'];
    }
}

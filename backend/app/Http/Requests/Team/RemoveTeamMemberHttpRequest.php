<?php

declare(strict_types=1);

namespace App\Http\Requests\Team;

use App\Http\Request\ApiFormRequest;
use App\Rules\IsWebsiteRelatedToUser;

final class RemoveTeamMemberHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'website_id' => [
                'required',
                'integer',
                new IsWebsiteRelatedToUser()
            ],
        ];
    }

    public function websiteId(): int
    {
        return (int)$this->get('website_id');
    }
}

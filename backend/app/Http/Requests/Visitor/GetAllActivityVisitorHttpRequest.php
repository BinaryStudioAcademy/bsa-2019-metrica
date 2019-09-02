<?php

declare(strict_types=1);

namespace App\Http\Requests\Visitor;
use App\Rules\IsWebsiteRelatedWithUser;

use App\Http\Request\ApiFormRequest;

final class GetAllActivityVisitorHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'website_id' => [
                'required',
                'integer',
                new IsWebsiteRelatedWithUser()
            ]
        ];
    }

    public function websiteId(): int
    {
        return $this->get('website_id');
    }
}

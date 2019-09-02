<?php

declare(strict_types=1);

namespace App\Http\Requests\Session;

use App\Http\Request\ApiFormRequest;
use App\Rules\IsWebsiteRelatedWithUser;

final class GetAvgSessionHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'filter.startDate' => 'required|integer',
            'filter.endDate' => 'required|integer',
            'filter.website_id' => ['required','integer', new IsWebsiteRelatedWithUser()],
        ];
    }

    public function startDate(): string
    {
        return $this->validated()['filter']['startDate'];
    }

    public function endDate(): string
    {
        return $this->validated()['filter']['endDate'];
    }

    public function websiteId(): int
    {
        return (int) $this->validated()['filter']['website_id'];
    }
}

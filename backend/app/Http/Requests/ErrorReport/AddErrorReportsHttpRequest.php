<?php

declare(strict_types=1);

namespace App\Http\Requests\ErrorReport;

use App\Http\Request\ApiFormRequest;

final class AddErrorReportsHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'stack_trace' => 'required|string',
            'message' => 'required|string',
            'page' => 'required|string',
            'page_title' => 'required|string',
        ];
    }

    public function page(): string
    {
        return $this->validated()['page'];
    }

    public function message(): string
    {
        return $this->validated()['message'];
    }

    public function pageTitle(): string
    {
        return $this->get('page_title');
    }

    public function stackTrace(): string
    {
        return $this->validated()['stack_trace'];
    }

    public function trackingNumber(): string
    {
        return $this->validated()['tracking_number'];
    }

    public function token(): ?string
    {
        return $this->header('X-Visitor');
    }

    public function trackNumber(): string
    {
        return $this->header('X-Website');
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests\ErrorReport;

use App\Http\Request\ApiFormRequest;

final class AddErrorReportsHttpRequest extends ApiFormRequest
{
    const PAGE = 'page';
    const MESSAGE = 'message';
    const PAGE_TITLE = 'page_title';
    const STACK_TRACE = 'stack_trace';
    const TRACKING_NUMBER = 'X-Visitor';
    const HEADER_X_WEBSITE = 'X-Website';

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
        return $this->get(self::PAGE);
    }

    public function message(): string
    {
        return $this->get(self::MESSAGE);
    }

    public function pageTitle(): string
    {
        return $this->get(self::PAGE_TITLE);
    }

    public function stackTrace(): string
    {
        return $this->get(self::STACK_TRACE);
    }

    public function token(): ?string
    {
        return $this->header(self::TRACKING_NUMBER);
    }

    public function trackNumber(): string
    {
        return $this->header(self::HEADER_X_WEBSITE);
    }
}

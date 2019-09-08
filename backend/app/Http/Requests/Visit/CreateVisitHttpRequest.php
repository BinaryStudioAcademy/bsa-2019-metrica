<?php

declare(strict_types=1);

namespace App\Http\Requests\Visit;

use App\Exceptions\MissingHeaderException;
use App\Http\Request\ApiFormRequest;

final class CreateVisitHttpRequest extends ApiFormRequest
{
    const PAGE = 'page';
    const LANGUAGE = 'language';
    const PAGE_TITLE = 'page_title';
    const DEVICE = 'device';
    const RESOLUTION_WIDTH = 'resolution_width';
    const RESOLUTION_HEIGHT = 'resolution_height';
    const PAGE_LOAD_TIME = 'page_load_time';
    const HEADER_X_VISITOR = 'X-Visitor';

    public function rules(): array
    {
        if (!$this->hasHeader(self::HEADER_X_VISITOR)) {
            throw new MissingHeaderException(self::HEADER_X_VISITOR);
        }

        return [
            'page' => 'required|string',
            'page_title' => 'required|string',
            'language' => 'required|string',
            'device' => 'required|string',
            'page_load_time' => 'integer',
            'resolution_width' => 'required|integer',
            'resolution_height' => 'required|integer'
        ];
    }

    public function page(): string
    {
        return $this->get(self::PAGE);
    }

    public function pageTitle(): string
    {
        return $this->get(self::PAGE_TITLE);
    }

    public function language(): string
    {
        return $this->get(self::LANGUAGE);
    }

    public function device(): string
    {
        return $this->get(self::DEVICE);
    }

    public function resolutionWidth(): int
    {
        return $this->get(self::RESOLUTION_WIDTH);
    }

    public function resolutionHeight(): int
    {
        return $this->get(self::RESOLUTION_HEIGHT);
    }

    public function pageLoadTime(): ?int
    {
        return $this->get(self::PAGE_LOAD_TIME);
    }

    public function token(): string
    {
        return $this->header(self::HEADER_X_VISITOR);
    }
}

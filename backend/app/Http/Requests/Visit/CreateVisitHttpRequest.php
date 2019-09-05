<?php

declare(strict_types=1);

namespace App\Http\Requests\Visit;

use App\Exceptions\MissingHeaderException;
use App\Http\Request\ApiFormRequest;

final class CreateVisitHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        if (!$this->hasHeader('X-Visitor')) {
            throw new MissingHeaderException('X-Visitor');
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
        return $this->get('page');
    }

    public function pageTitle(): string
    {
        return $this->get('page_title');
    }

    public function language(): string
    {
        return $this->get('language');
    }

    public function device(): string
    {
        return $this->get('device');
    }

    public function resolutionWidth(): int
    {
        return $this->get('resolution_width');
    }

    public function resolutionHeight(): int
    {
        return $this->get('resolution_height');
    }

    public function pageLoadTime(): ?int
    {
        return $this->get('page_load_time');
    }

    public function token(): string
    {
        return $this->header('X-Visitor');
    }
}

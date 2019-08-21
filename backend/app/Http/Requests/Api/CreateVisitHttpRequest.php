<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

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
            'page' => 'required|url',
            'page_title' => 'required|string',
            'language' => 'required|string',
            'operating_system' =>  'required|string',
            'device' => 'required|string',
            'resolution_width' => 'required|string',
            'resolution_height' => 'required|string'
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

    public function operatingSystem(): string
    {
        return $this->get('operating_system');
    }

    public function device(): string
    {
        return $this->get('device');
    }

    public function resolutionWidth(): string
    {
        return $this->get('resolution_width');
    }

    public function resolutionHeight(): string
    {
        return $this->get('resolution_height');
    }

    public function token(): string
    {
        return $this->header('X-Visitor');
    }
}

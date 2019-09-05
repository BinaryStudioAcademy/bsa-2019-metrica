<?php

declare(strict_types=1);

namespace App\Http\Requests\ErrorReports;

use App\Http\Request\ApiFormRequest;

final class AddErrorReportsHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'stack_trace' => 'required|string',
            'message' => 'required|string',
            'page' => 'required|string',
            'tracking_number' => 'required|string',
        ];
    }

    public function getPage()
    {
        return $this->validated()['page'];
    }

    public function getMessage()
    {
        return $this->validated()['message'];
    }

    public function getStackTrace()
    {
        return $this->validated()['stack_trace'];
    }

    public function getTrackingNumber()
    {
        return $this->validated()['tracking_number'];
    }
}

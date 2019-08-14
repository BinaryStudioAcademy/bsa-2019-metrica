<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use phpDocumentor\Reflection\Types\Integer;

final class SessionHttpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_session' => 'required|number',
            'visitor_id' => 'required|number',
            'entrance_page_id' => 'required|number',
            'demographic_id' => 'required|number',
            'device_id' => 'required|number',
            'system_id' => 'required|number',
            'website_id' => 'required|number',
        ];
    }

    public function startSession(): integer
    {
        return $this->get('start_session');
    }

    public function visitorId(): integer
    {
        return $this->get('visitor_id');
    }

    public function entrancePageId(): integer
    {
        return $this->get('entrance_page_id');
    }

    public function demographicId(): integer
    {
        return $this->get('demographic_id');
    }

    public function deviceId(): integer
    {
        return $this->get('device_id');
    }

    public function systemId(): integer
    {
        return $this->get('system_id');
    }

    public function websiteId(): integer
    {
        return $this->get('website_id');
    }
}

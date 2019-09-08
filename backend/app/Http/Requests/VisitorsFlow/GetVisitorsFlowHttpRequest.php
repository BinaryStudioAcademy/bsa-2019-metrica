<?php
declare(strict_types=1);

namespace App\Http\Requests\VisitorsFlow;

use App\Http\Request\ApiFormRequest;

final class GetVisitorsFlowHttpRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'filter' => 'required|string',
        ];
    }

    public function getType(): string
    {
        return $this->get('filter');
    }
}

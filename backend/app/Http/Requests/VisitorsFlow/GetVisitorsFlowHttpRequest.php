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
            'level' => 'required|int'
        ];
    }

    public function getParameter(): string
    {
        return $this->get('filter');
    }

    public function getLevel(): int
    {
        return (int) $this->get('level');
    }
}

<?php

declare(strict_types=1);


namespace App\Actions\Auth;


use App\Http\Requests\Api\ConfirmEmailHttpRequest;

class ConfirmEmailRequest
{
    private $token;

    private function __construct(string $token)
    {
        $this->token = $token;
    }

    public static function fromRequest(ConfirmEmailHttpRequest $request): self
    {
        return new static($request->getToken());
    }

    public function getToken(): string
    {
        return $this->token;
    }
}

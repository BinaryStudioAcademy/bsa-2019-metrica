<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;


use App\Http\Requests\ResetPasswordHttpRequest;
use App\Http\Controllers\Controller;
use App\Actions\Auth\SendResetPasswordLinkAction;
use App\Actions\Auth\ResetPasswordRequest;

final class ResetPasswordController extends Controller
{
    private $sendLinkAction;

    public function __construct(SendResetPasswordLinkAction $sendLinkAction)
    {
        $this->sendLinkAction = $sendLinkAction;

    }

    public function sendPasswordResetLink(ResetPasswordHttpRequest $request)
    {

        $serviceResponse = $this->sendLinkAction->execute(
            new ResetPasswordRequest(
                $request->get('email')
            )
        );


        return response()->json('', $serviceResponse->getCode());
    }
}

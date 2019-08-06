<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Requests\ResetPasswordHttpRequest;
use App\Http\Controllers\Controller;
use App\Action\Auth\SendResetPasswordLinkAction;
use App\Action\Auth\ResetPasswordRequest;
use App\Exceptions\UserByEmailNotFoundException;

class ResetPasswordController extends Controller
{
    private $sendLinkAction;

    public function __construct(SendResetPasswordLinkAction $sendLinkAction)
    {
        $this->sendLinkAction = $sendLinkAction;

    }

    public function sendPasswordResetLink(ResetPasswordHttpRequest $request)
    {
        try {
            $serviseResponse = $this->sendLinkAction->execute(
                new ResetPasswordRequest(
                    $request->get('email')
                )
            );
        } catch (UserByEmailNotFoundException $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ], 404);
        }

        return response()->json([
            "status" => $serviseResponse->getStatus()
        ], $serviseResponse->getCode());
    }
}

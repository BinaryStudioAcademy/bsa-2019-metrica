<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\ConfirmEmailAction;
use App\Actions\Auth\ConfirmEmailRequest;
use App\Exceptions\UserActivatedException;
use App\Http\Requests\Api\ConfirmEmailHttpRequest;
use App\Http\Requests\ResetPasswordHttpRequest;
use App\Http\Controllers\Controller;
use App\Actions\Auth\SendResetPasswordLinkAction;
use App\Actions\Auth\ResetPasswordRequest;
use App\Http\Resources\MessageResource;
use App\Http\Response\ApiResponse;

final class ResetPasswordController extends Controller
{
    private $sendLinkAction;
    private $confirmEmailAction;

    public function __construct(
        SendResetPasswordLinkAction $sendLinkAction,
        ConfirmEmailAction $confirmEmailAction
    )
    {
        $this->sendLinkAction = $sendLinkAction;
        $this->confirmEmailAction = $confirmEmailAction;
    }

    public function sendPasswordResetLink(ResetPasswordHttpRequest $request)
    {
        $response = $this->sendLinkAction->execute(
            new ResetPasswordRequest(
                $request->get('email')
            )
        );

        return ApiResponse::success(new MessageResource($response));
    }

    public function confirmEmail(ConfirmEmailHttpRequest $request): ApiResponse
    {
        $response = $this->confirmEmailAction->execute(ConfirmEmailRequest::fromRequest($request));
        return ApiResponse::success(new MessageResource($response));
    }
}

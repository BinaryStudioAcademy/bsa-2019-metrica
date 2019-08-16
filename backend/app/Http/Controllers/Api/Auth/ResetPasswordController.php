<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\TokenCouldNotCreate;
use App\Exceptions\UserByEmailNotFoundException;
use App\Http\Requests\ResetPasswordHttpRequest;
use App\Http\Controllers\Controller;
use App\Actions\Auth\SendResetPasswordLinkAction;
use App\Actions\Auth\ResetPasswordRequest;
use App\Http\Resources\MessageResource;
use App\Http\Response\ApiResponse;

final class ResetPasswordController extends Controller
{
    private $sendLinkAction;

    public function __construct(SendResetPasswordLinkAction $sendLinkAction)
    {
        $this->sendLinkAction = $sendLinkAction;
    }

    public function sendPasswordResetLink(ResetPasswordHttpRequest $request)
    {
        try {
            $response = $this->sendLinkAction->execute(
                new ResetPasswordRequest(
                    $request->get('email')
                )
            );
        } catch (UserByEmailNotFoundException|TokenCouldNotCreate $exception) {
            return ApiResponse::error($exception);
        }

        return ApiResponse::success(new MessageResource($response));
    }
}

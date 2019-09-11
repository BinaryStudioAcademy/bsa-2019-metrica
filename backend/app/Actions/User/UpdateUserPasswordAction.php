<?php
declare(strict_types=1);

namespace App\Actions\User;

use App\Exceptions\ResetPasswordException;
use App\Exceptions\UserNotFoundException;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class UpdateUserPasswordAction
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UpdateUserPasswordRequest $request): UpdateUserPasswordResponse
    {
        $user = auth()->user();
        if (!$user) {
            throw new ResetPasswordException();
        }
        try {
            $user = $this->userRepository->getByEmail($user->email);
        } catch (ModelNotFoundException $exception) {
            throw new UserNotFoundException();
        }
        $user->password = Hash::make($request->getPassword());
        $this->userRepository->save($user);
        return new UpdateUserPasswordResponse();
    }
}

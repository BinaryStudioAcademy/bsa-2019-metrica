<?php
declare(strict_types=1);

namespace App\Actions\Auth;

use App\Exceptions\UserActivatedException;
use App\Repositories\Contracts\UserRepository;

final class ConfirmEmailAction
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ConfirmEmailRequest $request): ConfirmEmailResponse
    {
        if ((bool)auth()->user()->is_activate) {
            throw new UserActivatedException("This account has already activated");
        } else {
            $this->repository->activateUser(auth()->user()->email);
            return new ConfirmEmailResponse();
        }
    }
}

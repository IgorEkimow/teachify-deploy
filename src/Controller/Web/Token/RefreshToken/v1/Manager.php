<?php

namespace App\Controller\Web\Token\RefreshToken\v1;

use App\Application\Security\AuthService;
use App\Domain\Service\UserService;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class Manager
{
    public function __construct(
        private AuthService $authService,
        private UserService $userService,
    ) {
    }

    public function refreshToken(UserInterface $user): string
    {
        $this->userService->clearUserToken($user->getUserIdentifier());

        return $this->authService->getToken($user->getUserIdentifier());
    }
}
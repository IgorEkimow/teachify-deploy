<?php

namespace App\Controller\Web\Admin\Create\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateAdminDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        public string $login,
        #[Assert\NotBlank]
        public string $password,
        public array $roles = ['ROLE_ADMIN']
    ) {
    }
}
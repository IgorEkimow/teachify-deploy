<?php

namespace App\Controller\Web\Teacher\Create\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateTeacherDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        public string $login,
        #[Assert\NotBlank]
        public string $password,
        #[Assert\NotBlank]
        public array $skills,
        public array $roles = ['ROLE_TEACHER']
    ) {
    }
}
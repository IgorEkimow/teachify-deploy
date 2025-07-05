<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateTeacherModel
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
        public array $roles = []
    ) {
    }
}
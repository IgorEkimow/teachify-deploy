<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

readonly class GetAllStudentModel
{
    public function __construct(
        #[Assert\NotBlank]
        public int $id,
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        public string $login,
        public string $createdAt,
        public string $updatedAt,
        public array $skills,
        public array $roles
    ) {
    }
}
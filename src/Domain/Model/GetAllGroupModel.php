<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

readonly class GetAllGroupModel
{
    public function __construct(
        #[Assert\NotBlank]
        public int $id,
        #[Assert\NotBlank]
        public string $name,
        public string $createdAt,
        public string $updatedAt,
        public array $skills
    ) {
    }
}
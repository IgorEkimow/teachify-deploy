<?php

namespace App\Controller\Web\Student\Get\GetById\v1\Output;

use App\Controller\DTO\OutputDTOInterface;

readonly class GotStudentDTO implements OutputDTOInterface
{
    public function __construct(
        public int $id,
        public string $name,
        public string $login,
        public string $createdAt,
        public string $updatedAt,
        public array $skills
    ) {
    }
}
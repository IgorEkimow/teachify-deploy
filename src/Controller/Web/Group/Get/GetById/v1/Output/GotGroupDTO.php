<?php

namespace App\Controller\Web\Group\Get\GetById\v1\Output;

use App\Controller\DTO\OutputDTOInterface;

readonly class GotGroupDTO implements OutputDTOInterface
{
    public function __construct(
        public int $id,
        public string $name,
        public string $createdAt,
        public string $updatedAt,
        public array $skills,
        public array $students,
        public ?string $teacher = '',
    ) {
    }
}
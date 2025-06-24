<?php

namespace App\Controller\Web\Group\Create\v1\Output;

use App\Controller\DTO\OutputDTOInterface;

class CreatedGroupDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $createdAt,
        public readonly string $updatedAt
    ) {
    }
}
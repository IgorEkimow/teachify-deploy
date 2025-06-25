<?php

namespace App\Controller\Web\Group\Get\GetAll\v1;

use App\Domain\Service\GroupService;

readonly class Manager
{
    public function __construct(private GroupService $groupService)
    {
    }

    public function getAll(): array
    {
        return $this->groupService->findAll();
    }
}
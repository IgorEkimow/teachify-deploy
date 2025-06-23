<?php

namespace App\Controller\Web\Group\Create\v1;

use App\Domain\Entity\Group;
use App\Domain\Service\GroupService;

class Manager
{
    public function __construct(private readonly GroupService $groupService)
    {
    }

    public function create(string $name): ?Group
    {
        return $this->groupService->findByName($name) ?? $this->groupService->create($name);
    }
}
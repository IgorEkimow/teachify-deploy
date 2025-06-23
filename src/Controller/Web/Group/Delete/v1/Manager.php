<?php

namespace App\Controller\Web\Group\Delete\v1;

use App\Domain\Entity\Group;
use App\Domain\Service\GroupService;

class Manager
{
    public function __construct(private readonly GroupService $groupService)
    {
    }

    public function delete(Group $group): void
    {
        $this->groupService->remove($group);
    }
}
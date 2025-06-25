<?php

namespace App\Controller\Web\Group\Delete\v1;

use App\Domain\Entity\Group;
use App\Domain\Service\GroupService;

readonly class Manager
{
    public function __construct(private GroupService $groupService)
    {
    }

    public function delete(Group $group): void
    {
        $this->groupService->remove($group);
    }
}
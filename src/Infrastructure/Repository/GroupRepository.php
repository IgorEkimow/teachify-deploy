<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Group;

/**
 * @extends AbstractRepository<Group>
 */
class GroupRepository extends AbstractRepository
{
    public function create(Group $group): int
    {
        return $this->store($group);
    }
}
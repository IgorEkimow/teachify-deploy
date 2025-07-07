<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Group;

interface GroupRepositoryInterface
{
    /**
     * @return Group[]
     */
    public function getAllCached(): array;
}
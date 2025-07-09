<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Admin;

interface AdminRepositoryInterface
{
    /**
     * @return Admin[]
     */
    public function getAllCached(): array;
}
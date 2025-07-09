<?php

namespace App\Controller\Web\Admin\Get\GetAll\v1;

use App\Domain\Repository\AdminRepositoryInterface;

readonly class Manager
{
    public function __construct(private AdminRepositoryInterface $adminRepositoryInterface)
    {
    }

    public function getAllAdmins(): array
    {
        return $this->adminRepositoryInterface->getAllCached();
    }
}
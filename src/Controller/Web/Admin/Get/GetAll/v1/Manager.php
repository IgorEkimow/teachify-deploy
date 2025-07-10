<?php

namespace App\Controller\Web\Admin\Get\GetAll\v1;

use App\Domain\Entity\Admin;
use App\Domain\Service\AdminService;

readonly class Manager
{
    public function __construct(private AdminService $adminService)
    {
    }

    public function getAll(): array
    {
        return array_map(static fn (Admin $admin): array => $admin->toArray(), $this->adminService->findAll());
    }
}
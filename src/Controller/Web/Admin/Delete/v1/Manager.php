<?php

namespace App\Controller\Web\Admin\Delete\v1;

use App\Domain\Entity\Admin;
use App\Domain\Service\AdminService;

readonly class Manager
{
    public function __construct(private AdminService $adminService)
    {
    }

    public function deleteAdmin(Admin $admin): void
    {
        $this->adminService->remove($admin);
    }
}
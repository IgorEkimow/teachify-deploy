<?php

namespace App\Controller\Web\Admin\Create\v1;

use App\Controller\Web\Admin\Create\v1\Input\CreateAdminDTO;
use App\Controller\Web\Admin\Create\v1\Output\CreatedAdminDTO;
use App\Domain\Model\CreateAdminModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\AdminService;

readonly class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateAdminModel> */
        private ModelFactory $modelFactory,
        private AdminService $adminService,
    ) {
    }

    public function create(CreateAdminDTO $createAdminDTO): CreatedAdminDTO
    {
        $createAdminModel = $this->modelFactory->makeModel(
            CreateAdminModel::class,
            trim($createAdminDTO->name),
            trim($createAdminDTO->login),
            trim($createAdminDTO->password),
            $createAdminDTO->roles
        );
        $admin = $this->adminService->findByLogin($createAdminModel) ?? $this->adminService->create($createAdminModel);

        return new CreatedAdminDTO(
            $admin->getId(),
            $admin->getName(),
            $admin->getLogin(),
            $admin->getCreatedAt()->format('Y-m-d H:i:s'),
            $admin->getUpdatedAt()->format('Y-m-d H:i:s'),
            $admin->getRoles()
        );
    }
}
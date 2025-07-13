<?php

namespace App\Controller\Web\Admin\Create\v1;

use App\Controller\Web\Admin\Create\v1\Input\CreateAdminDTO;
use App\Controller\Web\Admin\Create\v1\Output\CreatedAdminDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    public function __construct(private Manager $manager)
    {
    }

    #[Route(path: 'api/v1/register/admin', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateAdminDTO $createAdminDTO): CreatedAdminDTO
    {
        return $this->manager->create($createAdminDTO);
    }
}
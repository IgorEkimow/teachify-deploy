<?php

namespace App\Controller\Web\Group\Create\v1;

use App\Controller\Web\Group\Create\v1\Input\CreateGroupDTO;
use App\Controller\Web\Group\Create\v1\Output\CreatedGroupDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller {
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(path: 'api/v1/group', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateGroupDTO $createGroupDTO) : CreatedGroupDTO
    {
        return $this->manager->create($createGroupDTO);
    }
}
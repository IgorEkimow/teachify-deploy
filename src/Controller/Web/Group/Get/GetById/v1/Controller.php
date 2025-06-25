<?php

namespace App\Controller\Web\Group\Get\GetById\v1;

use App\Controller\Web\Group\Get\GetById\v1\Input\GetGroupDTO;
use App\Controller\Web\Group\Get\GetById\v1\Output\GotGroupDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    public function __construct(private Manager $manager)
    {
    }

    #[Route(path: 'api/v1/group', methods: ['GET'])]
    public function __invoke(#[MapQueryString] GetGroupDTO $getGroupDTO): GotGroupDTO
    {
        return $this->manager->getGroupById($getGroupDTO);
    }
}
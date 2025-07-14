<?php

namespace App\Domain\Bus;

use App\Domain\DTO\AssignGroupDTO;

interface AssignGroupBusInterface
{
    public function sendAssignGroupMessage(AssignGroupDTO $assignGroupDTO);
}
<?php

namespace App\Domain\Bus;

use App\Domain\DTO\AssignTeacherDTO;

interface AssignTeacherBusInterface
{
    public function sendAssignTeacherMessage(AssignTeacherDTO $assignTeacherDTO);
}
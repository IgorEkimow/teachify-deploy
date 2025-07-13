<?php

namespace App\Infrastructure\Bus;

enum AmqpQueueEnum: string
{
    case AssignTeacher = 'assign_teacher';
}
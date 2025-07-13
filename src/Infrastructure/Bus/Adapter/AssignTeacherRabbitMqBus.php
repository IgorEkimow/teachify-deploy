<?php

namespace App\Infrastructure\Bus\Adapter;

use App\Domain\Bus\AssignTeacherBusInterface;
use App\Domain\DTO\AssignTeacherDTO;
use App\Infrastructure\Bus\AmqpQueueEnum;
use App\Infrastructure\Bus\RabbitMqBus;

class AssignTeacherRabbitMqBus implements AssignTeacherBusInterface
{
    public function __construct(private readonly RabbitMqBus $rabbitMqBus)
    {
    }

    public function sendAssignTeacherMessage(AssignTeacherDTO $assignTeacherDTO): bool
    {
        return $this->rabbitMqBus->publishToExchange(AmqpQueueEnum::AssignTeacher, $assignTeacherDTO);
    }
}
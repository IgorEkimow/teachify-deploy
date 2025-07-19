<?php

namespace App\Infrastructure\Bus\Adapter;

use App\Domain\Bus\AssignGroupBusInterface;
use App\Domain\DTO\AssignGroupDTO;
use App\Infrastructure\Bus\AmqpQueueEnum;
use App\Infrastructure\Bus\RabbitMqBus;

class AssignGroupRabbitMqBus implements AssignGroupBusInterface
{
    public function __construct(private readonly RabbitMqBus $rabbitMqBus)
    {
    }

    public function sendAssignGroupMessage(AssignGroupDTO $assignGroupDTO): bool
    {
        return $this->rabbitMqBus->publishToExchange(AmqpQueueEnum::AssignGroup, $assignGroupDTO);
    }
}
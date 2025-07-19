<?php

namespace App\Controller\Amqp\AssignGroup\Input;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    public function __construct(
        #[Assert\Type('numeric')]
        public readonly int $id
    ) {
    }
}
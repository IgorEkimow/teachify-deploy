<?php

namespace App\Controller\Amqp\AssignTeacher\Input;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    public function __construct(
        #[Assert\Type('numeric')]
        public readonly int $id
    ) {
    }
}
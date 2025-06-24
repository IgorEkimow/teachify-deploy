<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreateGroupModel
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $name
    ) {
    }
}
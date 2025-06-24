<?php

namespace App\Controller\Web\Group\Create\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class CreateGroupDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $name
    ) {
    }
}
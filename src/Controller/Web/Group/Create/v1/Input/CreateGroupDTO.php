<?php

namespace App\Controller\Web\Group\Create\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateGroupDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        public array $skills = []
    ) {
    }
}
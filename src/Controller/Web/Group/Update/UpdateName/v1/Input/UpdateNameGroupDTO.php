<?php

namespace App\Controller\Web\Group\Update\UpdateName\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UpdateNameGroupDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name
    ) {
    }
}
<?php

namespace App\Controller\Web\Group\Get\GetById\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class GetGroupDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public int $id
    ) {
    }
}
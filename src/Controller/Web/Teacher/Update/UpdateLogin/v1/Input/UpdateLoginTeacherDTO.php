<?php

namespace App\Controller\Web\Teacher\Update\UpdateLogin\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UpdateLoginTeacherDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $login
    ) {
    }
}
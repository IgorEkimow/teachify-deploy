<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UpdateLoginTeacherModel
{
    public function __construct(
        #[Assert\NotBlank]
        public string $login
    ) {
    }
}
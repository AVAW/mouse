<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class Captcha extends Constraint
{
    public string $message = 'security.captcha.error';
}

<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class UniqueField extends Constraint
{
    public string $message = 'validator.uniqueField';

    public string $entityClass;

    public string $field;

    public function getRequiredOptions(): array
    {
        return [
            'entityClass',
            'field',
        ];
    }

    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
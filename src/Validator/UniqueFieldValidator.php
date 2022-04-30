<?php

namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;

class UniqueFieldValidator extends ConstraintValidator
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
    ) {
    }

    public function validate($value, Constraint $constraint)
    {
        $entityRepository = $this->entityManager->getRepository($constraint->entityClass);

        if (!is_scalar($constraint->field)) {
            throw new \InvalidArgumentException('"field" parameter should be any scalar type');
        }

        $result = $entityRepository->findBy([
            $constraint->field => $value,
        ]);

        if (count($result) > 0) {
            $this->context->buildViolation($this->translator->trans($constraint->message))
                ->addViolation();
        }
    }
}
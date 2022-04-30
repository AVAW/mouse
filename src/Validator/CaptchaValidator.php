<?php

namespace App\Validator;

use App\Service\CaptchaManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;

class CaptchaValidator extends ConstraintValidator
{
    public function __construct(
        private TranslatorInterface $translator,
        private CaptchaManager $captchaManager,
    ) {
    }

    public function validate($value, Constraint $constraint): void
    {
        $values = $this->context->getRoot()->getData();

        $identifier = (string)$values['captchaId'];

        if (!$this->captchaManager->validate($identifier, (int)$value)) {
            $this->context->buildViolation($this->translator->trans($constraint->message))
                ->addViolation();
        }
    }
}
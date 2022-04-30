<?php

namespace App\Service;

use App\Entity\Captcha;
use App\Repository\CaptchaRepository;
use Symfony\Component\Uid\UuidV4;

class CaptchaManager
{
    public function __construct(
       private CaptchaRepository $captchaRepository
    ) {
    }

    public function create(): Captcha
    {
        $captcha = new Captcha();
        $captcha->setIdentifier(new UuidV4());

        $this->captchaRepository->add($captcha);

        return $captcha;
    }

    public function validate(string $identifier, int $result): bool
    {
        $captcha = $this->captchaRepository->findByIdentifier(new UuidV4($identifier));
        if (!$captcha instanceof Captcha) {
            return false;
        }

        if ($captcha->getResult() === $result) {
            return true;
        }

        return false;
    }
}
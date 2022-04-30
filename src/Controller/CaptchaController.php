<?php

namespace App\Controller;

use App\Entity\Captcha;
use App\Repository\CaptchaRepository;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

class CaptchaController extends AbstractController
{
    #[Route('/captcha', name: 'app_captcha')]
    public function image(
        Request $request,
        CaptchaRepository $captchaRepository,
        string $fontsDir
    ): Response {
        $requestId = $request->query->all();
        $uuid = array_key_first($requestId);

        $x = 220;
        $y = 80;
        $canvas = imagecreatetruecolor($x, $y);
        for ($i = 0; $i < $x; $i++) {
            for ($j = 0; $j < $y; $j++) {
                $rand = rand(50, 255);
                $color = imagecolorallocate($canvas, $rand, $rand, $rand);
                imagesetpixel($canvas, $i, $j, $color);
            }
        }

        $fontColor = imagecolorallocate($canvas, 70, 70, 70);
        // not working: $fontPath = $fontsDir . DIRECTORY_SEPARATOR . 'akshar' . DIRECTORY_SEPARATOR . 'Akshar-SemiBold.ttf';
        $fontPath = $fontsDir . DIRECTORY_SEPARATOR . 'Akshar-SemiBold.ttf';
        $equation = $this->generateEquation();

        if (Uuid::isValid((string)$uuid)) {
            $captcha = $captchaRepository->findByIdentifier(new UuidV4($uuid));
            if ($captcha instanceof Captcha) {
                $captcha->setEquation($equation['equation']);
                $captcha->setResult($equation['result']);
                $captchaRepository->add($captcha);
            }
        }

        imagettftext($canvas, 30, 3, 25, 57, $fontColor, $fontPath, $equation['equation']);

        header('Content-Type: image/png');
        $image = imagepng($canvas);

        return new BinaryFileResponse($image);
    }

    #[ArrayShape(['result' => 'int', 'equation' => 'string'])]
    private function generateEquation(): array
    {
        $patterns = [
            '/ {equation} /',
            '\ {equation} \\',
            '| {equation} |',
            '. {equation} .',
        ];
        $pattern = $patterns[random_int(0, count($patterns) - 1)];

        $number1 = random_int(1, 9);
        $number2 = random_int(1, 9);

        return [
            'result' => $number1 + $number2,
            'equation' => str_replace('{equation}', "$number1 + $number2 = ?", $pattern),
        ];
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MouseController extends AbstractController
{
    #[Route('/mouse', name: 'app_mouse')]
    public function index(): Response
    {
        return $this->render('mouse/index.html.twig', [
        ]);
    }
}

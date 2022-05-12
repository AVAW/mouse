<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/anons')]
class ProductController extends AbstractController
{
    #[Route('/add', name: 'app_product_add')]
    public function add(): Response
    {
        return $this->render('product/add.html.twig', [

        ]);
    }
}

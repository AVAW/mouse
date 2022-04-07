<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/anonse')]
class CategoryController extends AbstractController
{
    #[Route('/panie', name: 'app_category_ladies')]
    public function ladies(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => 'ladies']);

        return $this->render('category/ladies.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/panowie', name: 'app_category_gentlemen')]
    public function gentlemen(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => 'gentlemen']);

        return $this->render('category/gentlemen.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/kluby', name: 'app_category_clubs')]
    public function clubs(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => 'clubs']);

        return $this->render('category/clubs.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/pary', name: 'app_category_couples')]
    public function couples(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => 'couples']);

        return $this->render('category/couples.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/masaz', name: 'app_category_massage')]
    public function massage(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => 'massage']);

        return $this->render('category/massage.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/bdms', name: 'app_category_bdms')]
    public function bdms(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => 'bdms']);

        return $this->render('category/bdms.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/striptiz', name: 'app_category_striptease')]
    public function striptease(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => 'striptease']);

        return $this->render('category/striptease.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/pokazy-sex-telefon', name: 'app_category_shows-phone-sex')]
    public function showsPhoneSex(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => 'shows-phone-sex']);

        return $this->render('category/shows_phone_sex.html.twig', [
            'category' => $category,
        ]);
    }
}

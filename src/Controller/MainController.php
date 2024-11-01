<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\SectionRepository;
use App\Repository\ArticleRepository;
class MainController extends AbstractController
{
    #[Route('/', name: 'homepage')]
public function index(SectionRepository $sectionRepository, ArticleRepository $articleRepository): Response
{
    $sections = $sectionRepository->findAll(); 
    
    // Obtener los últimos 5 artículos publicados
    $articles = $articleRepository->findBy(
        ['Published' => true],
        ['ArticleDateCreate' => 'DESC'],
        10 
    );
    
    return $this->render('main/index.html.twig', [
        'sections' => $sections,
        'articles' => $articles,  
    ]);
}
}

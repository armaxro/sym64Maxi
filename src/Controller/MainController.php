<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\SectionRepository;
class MainController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(SectionRepository $sectionRepository): Response
    {
        $sections = $sectionRepository->findAll(); 
        
        return $this->render('main/index.html.twig', [
            'sections' => $sections,
        ]);
    }
}

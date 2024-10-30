<?php

namespace App\Controller;

use App\Entity\Section;
use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SectionController extends AbstractController
{
    #[Route('/section/{id}', name: 'section')]
    public function show(Section $section, SectionRepository $sectionRepository): Response
    {
        // Obtener todas las secciones para el menú
        $sections = $sectionRepository->findAll();
        
        return $this->render('section/section.html.twig', [
            'section' => $section,
            'sections' => $sections
        ]);
    }
}
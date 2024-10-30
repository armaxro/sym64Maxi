<?php

namespace App\Controller;

use App\Entity\Section;
use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SectionController extends AbstractController
{
    #[Route('/section/{slug}', name: 'section')]
    public function show(string $slug, SectionRepository $sectionRepository): Response
    {
        // Obtener la sección por su slug
        $section = $sectionRepository->findOneBy(['SectionSlug' => $slug]);
        
        if (!$section) {
            throw $this->createNotFoundException('Section not found');
        }
        
        // Obtener todas las secciones para el menú
        $sections = $sectionRepository->findAll();
        
        return $this->render('section/section.html.twig', [
            'section' => $section,
            'sections' => $sections
        ]);
    }
}
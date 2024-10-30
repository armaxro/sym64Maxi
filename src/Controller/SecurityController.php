<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\SectionRepository;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils, SectionRepository $sectionRepository): Response
    {
        // Inicializar username como string vacío
        $username = '';
        
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // Si hay un username previo, lo usamos
        if ($authenticationUtils->getLastUsername()) {
            $username = $authenticationUtils->getLastUsername();
        }
        
        // get sections for navigation
        $sections = $sectionRepository->findAll();

        return $this->render('security/index.html.twig', [
            'username' => $username,
            'error' => $error,
            'sections' => $sections
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\SectionRepository;
use Doctrine\ORM\EntityManagerInterface;  
use App\Entity\Section; 

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(
        AuthenticationUtils $authenticationUtils, 
        SectionRepository $sectionRepository
    ): Response {

        $username = '';
        

        $error = $authenticationUtils->getLastAuthenticationError();
        

        if ($authenticationUtils->getLastUsername()) {
            $username = $authenticationUtils->getLastUsername();
        }
        

        $sections = $sectionRepository->findAll();

        return $this->render('security/index.html.twig', [
            'username' => $username,
            'error' => $error,
            'sections' => $sections  
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
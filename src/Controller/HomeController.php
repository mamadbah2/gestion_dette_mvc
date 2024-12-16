<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index')]
    public function index(Security $security): Response
    {
        if (
            !$this->isGranted('ROLE_BOUTIQUIER') &&
            !$this->isGranted('ROLE_ADMIN') &&
            !$this->isGranted('ROLE_CLIENT') &&
            !$this->isGranted('ROLE_USER')
        ) {
            throw $this->createAccessDeniedException('Accès refusé');
        }

        if ($this->isGranted('ROLE_BOUTIQUIER')) {
            return $this->render('home/boutiquier.html.twig');
        }

        // if ($this->isGranted('ROLE_ADMIN')) {
        //     return $this->render('home/admin.html.twig');
        // }

        if ($this->isGranted('ROLE_CLIENT')) {
            $user = $security->getUser();
            if ($user->getClient()) {
                return $this->render('home/client.html.twig', [
                    'client' => $user->getClient(),
                ]);
            }
            return $this->render('home/client.html.twig', [
                'client' => null,
            ]);
        }
        return $this->render('home/index.html.twig'); 

    }
}

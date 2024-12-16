<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/{id}/create', name:'user.create')]
    public function create(Request $req, EntityManagerInterface $em, Client $client): Response {
        $newUser = new User();
        $form = $this->createForm(UserFormType::class, $newUser);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $newUser->setActive(true);
            $newUser->setClient($client);
            $client->setUserAccount($newUser);
            $newUser->setClient($client);

            $em->persist($client);
            $em->persist($newUser);
            $em->flush();

            return $this->redirectToRoute('client.index');
        }
        return $this->render('user/create.html.twig', [
            'form'=> $form,
        ]);
    }
}

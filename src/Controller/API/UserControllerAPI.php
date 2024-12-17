<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class UserControllerAPI extends AbstractController
{
    #[Route('/api/user', name: 'user.api.index')]
    public function index(UserRepository $repository): Response
    {
        $users = $repository->findAll();
        return $this->json($users, Response::HTTP_OK, [], [
            'groups'=> 'user.api.index',
        ]);
    }

    #[Route("/api/user", name: 'user.api.create', methods: ["POST"])]
    public function create(
        Request $request,
        #[MapRequestPayload(
            serializationContext: [
                'groups' => ['user.create']
            ]
        )]
        User $user,
        EntityManagerInterface $em
    )
    {
        $em->persist($user);
        $em->flush();
        return $this->json($user, 200, [], [
            'groups' => ['recipes.index', 'recipes.show']
        ]);
    }

}

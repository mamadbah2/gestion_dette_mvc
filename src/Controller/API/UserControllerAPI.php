<?php

namespace App\Controller\API;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

}

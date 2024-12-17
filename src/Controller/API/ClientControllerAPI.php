<?php

namespace App\Controller\API;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientControllerAPI extends AbstractController 
{
    #[Route('/api/client', name: 'client.api.index')]
    public function index(ClientRepository $repository): Response
    {
        $clients = $repository->findAll();
        return $this->json($clients, 200, [], [
            'groups'=> 'client.api.index',
        ]);
    }

}
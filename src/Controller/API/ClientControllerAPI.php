<?php

namespace App\Controller\API;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class ClientControllerAPI extends AbstractController 
{
    #[Route('/api/client', name: 'client.api.index', methods: ['GET'])]
    public function index(ClientRepository $repository): Response
    {
        $clients = $repository->findAll();
        return $this->json($clients, 200, [], [
            'groups'=> 'client.api.index',
        ]);
    }

    #[Route("/api/client", name: 'client.api.create', methods: ["POST"])]
    public function create(
        Request $request,
        #[MapRequestPayload(
            serializationContext: [
                'groups' => ['client.create']
            ]
        )]
        Client $client,
        EntityManagerInterface $em
    )
    {
        $em->persist($client);
        $em->flush();
        return $this->json($client, 200, [], [
            'groups' => ['recipes.index', 'recipes.show']
        ]);
    }

}
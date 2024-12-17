<?php

namespace App\Controller\API;

use App\Entity\DebtRequest;
use App\Repository\DebtRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class DebtRequestControllerAPI extends AbstractController
{
    #[Route('api/debt/request', name: 'debt_request.api.index', methods: ['GET'])]
    public function index(DebtRequestRepository $repository): Response
    {
        $debtRequests = $repository->findAll();
        return $this->json($debtRequests, 200, [], [
            'groups'=> 'debt_request.api.index',
        ]);
    }
    
    #[Route("/api/debtrequest", name: 'debtrequest.api.create', methods: ["POST"])]
    public function create(
        Request $request,
        #[MapRequestPayload(
            serializationContext: [
                'groups' => ['debtrequest.create']
            ]
        )]
        DebtRequest $debtrequest,
        EntityManagerInterface $em
    ):Response
    {
        $em->persist($debtrequest);
        $em->flush();
        return $this->json($debtrequest, 200, [], [
            'groups' => ['debt_request.api.index']
        ]);
    }

}
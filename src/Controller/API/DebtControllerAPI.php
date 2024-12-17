<?php

namespace App\Controller\API;

use App\Entity\Debt;
use App\Repository\DebtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class DebtControllerAPI extends AbstractController 
{
    #[Route('/api/debt', name: 'debt.api.index', methods: ['GET'])]
    public function index(DebtRepository $repository): Response
    {
        $debts = $repository->findAll();
        return $this->json($debts, 200, [], [
            'groups'=> 'debt.api.index',
        ]);
    }

    #[Route("/api/debt", name: 'debt.api.create', methods: ["POST"])]
    public function create(
        Request $request,
        #[MapRequestPayload(
            serializationContext: [
                'groups' => ['debt.create']
            ]
        )]
        Debt $debt,
        EntityManagerInterface $em
    )
    {
        $em->persist($debt);
        $em->flush();
        return $this->json($debt, 200, [], [
            'groups' => ['debt.api.index']
        ]);
    }

}
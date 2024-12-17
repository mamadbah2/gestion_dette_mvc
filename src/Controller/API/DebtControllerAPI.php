<?php

namespace App\Controller\API;

use App\Repository\DebtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DebtControllerAPI extends AbstractController 
{
    #[Route('/api/debt', name: 'debt.api.index')]
    public function index(DebtRepository $repository): Response
    {
        $debts = $repository->findAll();
        return $this->json($debts, 200, [], [
            'groups'=> 'debt.api.index',
        ]);
    }

}
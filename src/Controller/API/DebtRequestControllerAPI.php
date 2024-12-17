<?php

namespace App\Controller\API;

use App\Repository\DebtRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DebtRequestControllerAPI extends AbstractController
{
    #[Route('api/debt/request', name: 'debt_request.api.index')]
    public function index(DebtRequestRepository $repository): Response
    {
        $debtRequests = $repository->findAll();
        return $this->json($debtRequests, 200, [], [
            'groups'=> 'debt_request.api.index',
        ]);
    }
}

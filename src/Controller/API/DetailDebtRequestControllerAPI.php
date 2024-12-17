<?php

namespace App\Controller\API;

use App\Repository\DetailDebtRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DetailDebtRequestControllerAPI extends AbstractController
{
    #[Route('api/detail/debt/request', name: 'api.detail_debt_request.index')]
    public function index(DetailDebtRequestRepository $repository): Response
    {
        $debtRequests = $repository->findAll();
         return $this->json($debtRequests, Response::HTTP_OK, [], [
             'groups'=> 'detail_debt_request.api.index',
         ]);
    }

    
}

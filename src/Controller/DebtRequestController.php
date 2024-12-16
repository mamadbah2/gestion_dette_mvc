<?php

namespace App\Controller;

use App\Repository\DebtRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DebtRequestController extends AbstractController
{
    #[Route('/debt/request', name: 'debt_request.index')]
    public function index(DebtRequestRepository $debtRequestRepository): Response
    {
        $debtRequests = $debtRequestRepository->findAll();

        return $this->render('debt_request/index.html.twig', [
            'debtRequests' => $debtRequests,
        ]);
    }
}

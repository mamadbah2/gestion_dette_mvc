<?php

namespace App\Controller;

use App\Repository\DebtRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DebtRequestController extends AbstractController
{
    #[Route('/debt/request', name: 'app_debt_request')]
    public function index(DebtRequestRepository $repository): Response
    {
        return $this->render('debt_request/index.html.twig', [
            'controller_name' => 'DebtRequestController',
        ]);
    }
}

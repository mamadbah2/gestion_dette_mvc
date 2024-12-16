<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DetailDebtRequestController extends AbstractController
{
    #[Route('/detail/debt/request', name: 'app_detail_debt_request')]
    public function index(): Response
    {
        return $this->render('detail_debt_request/index.html.twig', [
            'controller_name' => 'DetailDebtRequestController',
        ]);
    }
}

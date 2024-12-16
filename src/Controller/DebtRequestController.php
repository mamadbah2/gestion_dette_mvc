<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DebtRequestController extends AbstractController
{
    #[Route('/debt/request', name: 'debt_request.index')]
    public function index(): Response
    {
        return $this->render('debt_request/index.html.twig');
    }
}

<?php

namespace App\Controller\API;

use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaiementControllerAPI extends AbstractController
{
    #[Route('/api/payment', name: 'payment.api.index')]
    public function index(PaymentRepository $repository): Response
    {
        $payments = $repository->findAll();
        return $this->json($payments, Response::HTTP_OK, [], [
            'groups'=> 'payment.api.index',
        ]);
    }

}

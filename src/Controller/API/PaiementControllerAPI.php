<?php

namespace App\Controller\API;

use App\Entity\Payment;
use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
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

    #[Route("/api/payment", name: 'payment.api.create', methods: ["POST"])]
    public function create(
        Request $request,
        #[MapRequestPayload(
            serializationContext: [
                'groups' => ['payment.create']
            ]
        )]
        Payment $payment,
        EntityManagerInterface $em
    )
    {
        $em->persist($payment);
        $em->flush();
        return $this->json($payment, 200, [], [
            'groups' => ['recipes.index', 'recipes.show']
        ]);
    }

}

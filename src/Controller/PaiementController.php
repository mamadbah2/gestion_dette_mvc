<?php

namespace App\Controller;

use App\Entity\Debt;
use App\Entity\Payment;
use App\Form\PaiementFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaiementController extends AbstractController
{
    #[Route('/paiement', name: 'app_paiement')]
    public function index(): Response
    {
        return $this->render('paiement/index.html.twig', [
            'controller_name' => 'PaiementController',
        ]);
    }

    #[Route('/debt/{id}/paiement', name:'paiement.debt')]
    public function create(Request $request, EntityManagerInterface $em, Debt $debt): Response {
        $payment = new Payment();
        $form = $this->createForm(PaiementFormType::class, $payment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $payment->setDebt($debt);
            $em->persist($payment);
            $em->flush();
            return $this->redirectToRoute('debt.client', ['id'=> $debt->getClient()->getId()]);
        }
        
        return $this->render('paiement/create.html.twig', [
            'controller_name' => 'PaiementController',
            'form'=> $form,
        ]);
    }
}

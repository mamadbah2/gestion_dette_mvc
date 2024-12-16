<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Debt;
use App\Entity\DetailDebt;
use App\Form\DebtFormType;
use App\Form\DetailDebtFormType;
use App\Repository\ClientRepository;
use App\Repository\DebtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DebtController extends AbstractController
{
    #[Route('/debt', name: 'debt.index')]
    public function index(): Response
    {
        return $this->render('debt/index.html.twig', [
            'controller_name' => 'DebtController',
        ]);
    }

    #[Route('/debt/client/{id}', name: 'debt.client')]
    public function show(DebtRepository $repository, Client $client): Response
    {
        // Trouver les dettes du client
        $debts = $repository->findBy(['client' => $client]);
        // Mise a jour des dettes en fonction des paiements
        for ($i = 0; $i < count($debts); $i++) {
            $payments = $debts[$i]->getPayments();
            if ($payments) {
                $sum = 0;
                for ($j = 0; $j < count($payments); $j++) {
                    $sum += $payments[$j]->getAmount();
                }
                $debts[$i]->setPaidMount($sum);
                $debts[$i]->setRemainingMount($debts[$i]->getMount() - $sum);
            }
        }

        return $this->render('debt/show.html.twig', [
            'debts' => $debts,
            'client' => $client,
        ]);
    }

    #[Route('/debt/client/{id}/create', name: 'debt.create')]
    public function create(Request $req, ClientRepository $repos, EntityManagerInterface $em, int $id): Response
    {
        $client = $repos->find($id);
        if (!$client) {
            return $this->redirectToRoute('client.index');
        }
        $debt = new Debt();
        $debt->addDetailDebt(new DetailDebt());
        $form = $this->createForm(DebtFormType::class, $debt);
        // dd($form);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            // Calcul du montant de la dette
            $detailDebtArray = [];
            foreach ($debt->getDetailDebts() as $detailDebt) {
                $newDetailDebt = new DetailDebt();
                $newDetailDebt->setArticle($detailDebt->getArticle());
                $newDetailDebt->setDebt($debt);
                $newDetailDebt->setQuantity($detailDebt->getQuantity());
                $newDetailDebt->setPrix($detailDebt->getArticle()->getPrix() * $detailDebt->getQuantity());
                $debt->setMount($newDetailDebt->getPrix() + $debt->getMount());
                $detailDebtArray[] = $newDetailDebt;
            }
            $debt->setPaidMount(0);
            $debt->setRemainingMount($debt->getMount());
            $debt->setAchieved(false);
            $debt->setClient($client);
            $debt->setDetailDebts(new ArrayCollection($detailDebtArray));
            $em->persist($debt);
            $em->flush();
            return $this->redirectToRoute('debt.client', ['id' => $client->getId()]);
        }
        return $this->render('debt/create.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/debt/{id}/edit', name: 'debt.edit')]
    public function update(Request $req, EntityManagerInterface $em, Debt $debt)
    {
        $form = $this->createForm(DebtFormType::class, $debt);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($debt);
            $em->flush();
            return $this->redirectToRoute('debt.client', ['id' => $debt->getClient()->getId()]);
        }
        return $this->render('debt/edit.html.twig', [
            'form' => $form,
            'debt' => $debt,
        ]);
    }

    #[Route('/debt/{id}/delete', name: 'debt.delete')]
    public function delete(EntityManagerInterface $em, Debt $debt): Response
    {
        $em->remove($debt);
        $em->flush();
        return $this->redirectToRoute('debt.client', ['id' => $debt->getClient()->getId()]);
    }

    #[Route('/debt/{id}', name:'debt.detail')]
    public function detail(EntityManagerInterface $em, Debt $debt): Response {
        return $this->render('debt/detail.html.twig', [
            'debt' => $debt,
        ]);
    }

}

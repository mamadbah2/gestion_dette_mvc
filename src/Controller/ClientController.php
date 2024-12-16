<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientFormType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ClientController extends AbstractController
{

    // #[IsGranted("ROLE_BOUTIQUIER")]
    #[Route('/client', name: 'client.index')]
    public function index(ClientRepository $repository, Request $req): Response
    {
        if ($this->isGranted('ROLE_CLIENT')) {
            throw $this->createAccessDeniedException('Accès refusé');
        }
        // $this->denyAccessUnlessGranted('ROLE_USER');
        $userAccount = $req->query->get('userAccount');
        $telephoneNumber = $req->query->get('telephone');
        $client = $repository->findOneBy(['telephone'=> $telephoneNumber]);
        if ($client) {
            return $this->redirectToRoute('client.show', ['id' => $client->getId()]);
        }
        $clients = [];

        switch ($userAccount) {
            case "true":
                $clients = $repository->findByUserAccount(true);
                break;
            case "false":
                $clients = $repository->findByUserAccount(false);
                break;
            default:
                $clients = $repository->findAll();
        }

        return $this->render('client/index.html.twig', [
            'clients' => $clients,
            'userAccount' => $userAccount,
        ]);
    }

    #[Route('/client/{id}/show', name:'client.show')]
    public function show (ClientRepository $repository, int $id): Response
    {
        $client = $repository->find($id);
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }


    #[Route('/client/{id}/delete', name:'client.delete')]
    public function delete(ClientRepository $repository, EntityManagerInterface $em, int $id): Response
    {
        $client = $repository->find($id);
        $em->remove($client);
        $em->flush();
        return $this->redirectToRoute('client.index');
    }

    #[Route('/client/{id}/edit', name:'client.edit')]
    public function edit(Request $req, Client $client, EntityManagerInterface $em): Response {
        $form = $this->createForm(ClientFormType::class, $client);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('client.index');
        }
        return $this->render('client/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/client/create', name:'client.create')]
    public function create(EntityManagerInterface $em, Request $req): Response {
        $client = new Client();
        $form = $this->createForm(ClientFormType::class, $client);
        $form->handleRequest($req);
        // Si on valide le formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('client.index');
        }
        // Si on arrive sur la page du formulaire
        return $this->render('client/create.html.twig', [
            'form' => $form,
        ]);
    }

}

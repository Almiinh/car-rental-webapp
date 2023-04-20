<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Form\ContratType;
use App\Repository\ContratRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Entity\Voiture;
use App\Repository\VoitureRepository;

/**
 * @Route("/contrat")
 */
class ContratController extends AbstractController
{
    /**
     * @Route("/", name="app_contrat_index", methods={"GET"})
     */
    public function index(ContratRepository $contratRepository): Response
    {
        return $this->render('contrat/index.html.twig', [
            'contrats' => $contratRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_contrat_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ContratRepository $contratRepository): Response
    {
        $contrat = new Contrat();
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contratRepository->add($contrat, true);

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrat/new.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }
    
    /**
     * @Route("new/selectclient", name="app_contrat_selectclient", methods={"GET"})
     */
    public function selectClient(ClientRepository $clientRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
            'chooseButton' => true, 
            'choosePath' => 'contrat',
        ]);
    }

    /**
     * @Route("new/client={id};selectvoiture", name="app_contrat_selectvoiture", methods={"GET"})
     */
    public function selectVoiture(Client $client, VoitureRepository $voitureRepository): Response
    {
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitureRepository->findAll(),
            'chooseButton' => true,
            'choosePath' => 'contrat',
            'client' => $client,
        ]);
    }

    /**
     * @Route("/new/client={client_id};voiture={voiture_id}", name="app_contrat_new_set", methods={"GET", "POST"})
     */
    public function newContrat(Request $request, int $client_id, int $voiture_id, ClientRepository $clientRepository, VoitureRepository $voitureRepository, ContratRepository $contratRepository): Response
    {
        $contrat = new Contrat();
        $client = $clientRepository->find($client_id);
        $voiture = $voitureRepository->find($voiture_id);
        $client->addContrat($contrat);
        $client->addVoiture($voiture);
        $voiture->setContrat($contrat);
        // if (!$this->voitures->contains($voiture)) {
            
        // } else {
        //     // render
        // }


        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contratRepository->add($contrat, true);

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrat/new.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_contrat_show", methods={"GET"})
     */
    public function show(Contrat $contrat): Response
    {
        return $this->render('contrat/show.html.twig', [
            'contrat' => $contrat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_contrat_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Contrat $contrat, ContratRepository $contratRepository): Response
    {
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contratRepository->add($contrat, true);

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrat/edit.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_contrat_delete", methods={"POST"})
     */
    public function delete(Request $request, Contrat $contrat, ContratRepository $contratRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contrat->getId(), $request->request->get('_token'))) {
            $contratRepository->remove($contrat, true);
        }

        return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
    }
}

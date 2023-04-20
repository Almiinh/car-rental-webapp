<?php

namespace App\Controller;

use App\Entity\Parking;
use App\Form\ParkingType;
use App\Repository\ParkingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;

/**
 * @Route("/parking")
 */
class ParkingController extends AbstractController
{
    /**
     * @Route("/", name="app_parking_index", methods={"GET"})
     */
    public function index(ParkingRepository $parkingRepository): Response
    {
        return $this->render('parking/index.html.twig', [
            'parkings' => $parkingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_parking_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ParkingRepository $parkingRepository): Response
    {
        $parking = new Parking();
        $form = $this->createForm(ParkingType::class, $parking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parkingRepository->add($parking, true);

            return $this->redirectToRoute('app_parking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parking/new.html.twig', [
            'parking' => $parking,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_parking_show", methods={"GET"})
     */
    public function show(Parking $parking): Response
    {
        return $this->render('parking/show.html.twig', [
            'parking' => $parking,
            'voitures' => $parking->getVoitures(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_parking_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Parking $parking, ParkingRepository $parkingRepository): Response
    {
        $form = $this->createForm(ParkingType::class, $parking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parkingRepository->add($parking, true);

            return $this->redirectToRoute('app_parking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parking/edit.html.twig', [
            'parking' => $parking,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}/add", name="app_parking_selectvoiture", methods={"GET"})
     */
    public function selectVoiture(Parking $parking ,VoitureRepository $voitureRepository): Response
    {
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitureRepository->findAll(),
            'chooseButton' => true,
            'choosePath' => 'parking',
            'parking' => $parking,
        ]);
    }

    /**
     * @Route("/{parking_id}/addvoiture={voiture_id}", name="app_parking_add", methods={"GET"})
     */
    public function addVoiture(int $parking_id, int $voiture_id ,ParkingRepository $parkingRepository, VoitureRepository $voitureRepository): Response
    {
        $parking = $parkingRepository->find($parking_id);
        $voiture = $voitureRepository->find($voiture_id);
        $parking->addVoiture($voiture);
        
        return $this->render('parking/show.html.twig', [
            'parking' => $parking,
            'voitures' => $parking->getVoitures(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_parking_delete", methods={"POST"})
     */
    public function delete(Request $request, Parking $parking, ParkingRepository $parkingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parking->getId(), $request->request->get('_token'))) {
            $parkingRepository->remove($parking, true);
        }

        return $this->redirectToRoute('app_parking_index', [], Response::HTTP_SEE_OTHER);
    }
}

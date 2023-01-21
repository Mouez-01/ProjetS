<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="app_reservation")
     */
    public function index(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {


     $reservation = new Reservation();
     $form = $this->createForm(ReservationType::class, $reservation);
     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
       
        $reservation = $form->getData();
        $entityManagerInterface->persist($reservation);
        $entityManagerInterface->flush();
     
        // return $this->redirectToRoute('app_reservation');
    }



        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'Sonia',
            'form' => $form->createView()
        ]);
    }
}

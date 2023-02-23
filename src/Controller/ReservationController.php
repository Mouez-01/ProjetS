<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
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
    public function index(Request $request,\Swift_Mailer $mailer, EntityManagerInterface $entityManagerInterface): Response
    {


     $reservation = new Reservation();
     $form = $this->createForm(ReservationType::class, $reservation);
     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
       
        $date = $form->get('date')->getData(); 
        $reservation = $form->getData();
         
        $entityManagerInterface->persist($reservation);
        $entityManagerInterface->flush();
     
        $message = (new \Swift_Message('Reservation')) 
        ->setFrom($reservation->getEmail()) 
        ->setTo('sonia@gmail.com') 
        ->setBody(
            $this->renderView(
                'emails/reservation.html.twig', compact('reservation')
            ),
            'text/html'
        )
    ;
    $mailer->send($message);

    $this->addFlash('message', 'Votre message a été transmis, nous vous répondrons dans les meilleurs délais.');  

    }



        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'Sonia',
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/listreservation", name="list_reservation")
     */

     public function list(ReservationRepository $reservationRepository){

        $reservation = $reservationRepository->findAll();
 
        return $this->render('reservation/liste.html.twig',[
            'reservations' => $reservation,
        ]);
    }
}

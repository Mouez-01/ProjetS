<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
   

    
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request,\Swift_Mailer $mailer,  EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
             
            $entityManager->persist($contact);
            $entityManager->flush(); 
            $message = (new \Swift_Message('Nouveau contact')) 
                ->setFrom($contact->getEmail()) 
                ->setTo('sonia@gmail.com') 
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig', compact('contact')
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);

            $this->addFlash('message', 'Votre message a été transmis, nous vous répondrons dans les meilleurs délais.'); // Permet un message flash de renvoi
        
        }
        return $this->render('contact/index.html.twig',
        ['form' => $form->createView()]
    );
      
    }

    /**
     * @Route("/list", name="list_contact")
     */

    public function list(ContactRepository $contactRepository){

        $contacts = $contactRepository->findAll();

        return $this->render('contact/list.html.twig',[
            'contacts' => $contacts,
        ]);
    }
}

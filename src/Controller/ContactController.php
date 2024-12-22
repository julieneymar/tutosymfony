<?php

namespace App\Controller;

use App\DTO\contactDTO;
use APP\Event\ContactResquestEvent;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]  
    public function contact(Request $request, MailerInterface $mailler, EventDispatcherInterface $dispather): Response
    {
        $data = new contactDTO();


        $data-> name = 'john';
        $data -> email = 'formationpourtoi@gmail.com';
        $data -> message = 'supersite';



        $form = $this -> createForm( ContactType::class, $data);
        $form ->handleRequest( $request);

        if($form -> isSubmitted() && $form-> isValid()){
            try{
                $dispather->dispatch(new ContactResquestEvent($data));
                $this-> addFlash('success', 'votre message à été bien envoyer');

            } catch(\Exception $e) {
                $this->addFlash('danger','Impossible d\'envoyer votre message');

            }
           
             /*
            $mail = (new TemplatedEmail())
                ->to ('contact@demo.fr')
                ->from($data->email)
                ->subject('Demande de contact')
                ->htmlTemplate('emails/contact.html.twig')
                ->context((['data'=> $data]));

            $mailler -> send($mail);
            $this ->addFlash('success', 'votre email à ete envoyer');
            return $this -> redirectToRoute('contact');    
        */
        }


        return $this-> render('contact/contact.html.twig', [
            'form' => $form,
        ]);
          

    }
}

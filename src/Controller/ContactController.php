<?php

namespace App\Controller;

use App\DTO\contactDTO;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]  
    public function contact(Request $request, MailerInterface $mailler): Response
    {
        $data = new contactDTO();


        $data-> name = 'john';
        $data -> email = 'formationpourtoi@gmail.com';
        $data -> message = 'supersite';



        $form = $this -> createForm( ContactType::class, $data);
        $form ->handleRequest( $request);

        if($form -> isSubmitted() && $form-> isValid()){
            $mail = (new TemplatedEmail())
                ->to ('contact@demo.fr')
                ->from($data->email)
                ->subject('Demande de contact')
                ->htmlTemplate('emails/contact.html.twig')
                ->context((['data'=> $data]));

            $mailler -> send($mail);
            $this ->addFlash('success', 'votre email à ete envoyer');
            return $this -> redirectToRoute('contact');    

        }


        return $this-> render('contact/contact.html.twig', [
            'form' => $form,
        ]);
          

    }
}

<?php

namespace App\EventSubscriber;
use APP\Event\ContactResquestEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;



use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Mailer;

class MaillingSubsciberSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly MailerInterface $mailler)
    {
        
    }



    public function onContactResquestEvent($event): void
    {
        $data = $event->data;
        $mail = (new TemplatedEmail())
                ->to ('contact@demo.fr')
                ->from($data->email)
                ->subject('Demande de contact')
                ->htmlTemplate('emails/contact.html.twig')
                ->context((['data'=> $data]));

            $this->mailler -> send($mail);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ContactResquestEvent::class => 'onContactResquestEvent',
        ];
    }
}

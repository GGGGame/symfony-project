<?php

namespace App\Listeners;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\EventDispatcher\Event;

class MailerListener
{
    private $mailer;
    
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onEmailEvent(Event $event)
    {

        $email = (new TemplatedEmail())
                ->from('noreply@test.it')
                ->to($event->getComment()->getEmail())
                ->subject('Time for Symfony mailer!')
                ->htmlTemplate('mailer/mailer.html.twig')
                ->context([
                    'username' => $event->getComment()->getAuthor()
                ]);

        $this->mailer->send($email);
    }
}
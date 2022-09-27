<?php

namespace App\Listeners;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\EventDispatcher\Event;

class MailerListener
{
    private $mailer;
    private $emailDetails;
    
    public function __construct(MailerInterface $mailer, array $details)
    {
        $this->mailer = $mailer;
        $this->emailDetails = $details;
    }

    public function onEmailEvent(Event $event)
    {

        $email = (new TemplatedEmail())
                ->from('noreply@test.it')
                ->to($this->emailDetails[0])
                ->subject('Time for Symfony mailer!')
                ->htmlTemplate('mailer/mailer.html.twig')
                ->context([
                    'username' => $this->emailDetails[1]
                ]);

        $this->mailer->send($email);
    }
}
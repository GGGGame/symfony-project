<?php

namespace App\Subscribers;

use App\Events\CommentEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;

class CommentSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            CommentEvent::NAME => 'onEmailEvent',
        ];
    }

    public function onEmailEvent(CommentEvent $event)
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
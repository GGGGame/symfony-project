<?php

namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;

class MailerEvent extends Event
{
    const NAME = 'mailer.event';

    protected $email;

    public function __construct()
    {
    }

    public function getEmail()
    {
        return $this->email;
    }
}
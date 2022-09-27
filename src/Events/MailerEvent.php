<?php

namespace App\Events;

use App\Entity\Comment;
use Symfony\Contracts\EventDispatcher\Event;

class MailerEvent extends Event
{
    const NAME = 'comment.mailer.event';

    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getComment(): Comment
    {
        return $this->comment;
    }
}
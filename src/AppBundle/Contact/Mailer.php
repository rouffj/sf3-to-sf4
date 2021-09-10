<?php

namespace AppBundle\Contact;

class Mailer
{
    const DEFAULT_SUBJECT = 'Contact from Hangman.com';

    private $mailer;
    private $sendFrom;
    private $sendTo;

    public function __construct(\Swift_Mailer $mailer, $sendFrom, $sendTo)
    {
        $this->mailer = $mailer;
        $this->sendFrom = $sendFrom;
        $this->sendTo = $sendTo;
    }

    public function sendMessage(Message $message)
    {
        $email = (new \Swift_Message())
            ->setFrom($this->sendFrom)
            ->setTo($this->sendTo)
            ->setReplyTo($message->email)
            ->setSubject($message->subject ?: self::DEFAULT_SUBJECT)
            ->setBody($message->content)
        ;

        $this->mailer->send($email);
    }
}

<?php

namespace App\Service;

use Twig\Environment;

class ContactService
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function handleForm(\App\Data\ContactData $data)
    {
        $message = (new \Swift_Message())
            ->setFrom($data->email)
            ->setTo('contact@monsite.fr')
            ->setBody($this->twig->render('emails/contact.html.twig', ['data' => $data]), 'text/html');
        $sent = $this->mailer->send($message);
        if ($sent !== 1) {
            throw new \Exception("SwiftMailer, les emails ne sont pas partis");
        }
    }
}

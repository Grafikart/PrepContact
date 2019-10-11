<?php

namespace App\Service;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
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
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(\Swift_Mailer $mailer, Environment $twig, EntityManagerInterface $em)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->em = $em;
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
        $this->em->persist(Contact::fromForm($data));
        $this->em->flush();
    }
}

<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Contact;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class ContactMailSubscriber implements EventSubscriberInterface
{
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(Environment $twig, \Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['sendMail', EventPriorities::POST_WRITE],
        ];
    }

    public function sendMail(ViewEvent $event)
    {
        $contact = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$contact instanceof Contact || Request::METHOD_POST !== $method) {
            return;
        }
        $message = (new \Swift_Message())
            ->setFrom($contact->getEmail())
            ->setTo('contact@monsite.fr')
            ->setBody($this->twig->render('emails/contact.html.twig', ['contact' => $contact]), 'text/html');
        $this->mailer->send($message);
    }
}

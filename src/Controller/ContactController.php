<?php

namespace App\Controller;

use App\Data\ContactData;
use App\Form\ContactType;
use App\Service\ContactService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, ContactService $service)
    {
        $data = new ContactData();
        $form = $this->createForm(ContactType::class, $data);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service->handleForm($data);
            $this->addFlash(
                'success',
                'Votre email a bien été envoyé'
            );
            return $this->redirectToRoute('contact');
        }
        return $this->render('page/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

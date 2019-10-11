<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(ContactRepository $repo)
    {
        $contacts = $repo->findRecent();
        return $this->render('admin/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }
}

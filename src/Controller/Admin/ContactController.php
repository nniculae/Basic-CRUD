<?php

namespace App\Controller\Admin;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/admin/contact/new", name="contact_new")
     */
    public function new()
    {
        $form = $this->createForm(ContactType::class);
        return $this->render('admin/contact/new.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}

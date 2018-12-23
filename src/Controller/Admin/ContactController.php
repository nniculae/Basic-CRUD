<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/admin/contact/new", name="contact_new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        // only on post
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $objectManager = $this->getDoctrine()->getManager();
            $objectManager->persist($form->getData());
            $objectManager->flush();

            $this->addFlash('success', 'The contact has been created.');
            return $this->redirectToRoute('admin_contact_list');
        }
        return $this->render('admin/contact/new.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/contact", name="admin_contact_list")
     */
    public function contactList(EntityManagerInterface $entityManager)
    {
        $contacts = $entityManager->getRepository(Contact::class)->findAll();
        return $this->render('admin/contact/list.html.twig', [
            'contacts' => $contacts,
        ]);
    }
}

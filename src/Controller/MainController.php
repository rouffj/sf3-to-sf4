<?php

namespace App\Controller;

use App\Form\Type\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route(name="app_main_index", methods={"GET"})
     */
    public function index()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('main/index.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'last_error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/contact", name="app_main_contact", methods={"GET", "POST"})
     */
    public function contact(Request $request)
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.contact.mailer')->sendMessage($form->getData());

            return $this->redirectToRoute('app_main_contact');
        }

        return $this->render('main/contact.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hello")
 */
class HelloController extends Controller
{
    /**
     * @Route(
     *     "/{name}",
     *     requirements={"name": "[a-zA-Z\-]+"},
     *     name="app_hello_index",
     *     methods={"GET"}
     * )
     */
    public function index($name = 'World')
    {
        $html = $this->get('translator')->trans("Hello %name%!", [
            '%name%' => $name,
        ]);

        return new Response($html);
    }

    /**
     * @Route(
     *     "/{matricule}",
     *     requirements={"matricule": "X\d+"},
     *     name="app_hello_robot",
     *     methods={"GET"}
     * )
     */
    public function robot($matricule)
    {
        $html = sprintf("Hello robot %s °_°!", $matricule);

        return new Response($html);
    }
}

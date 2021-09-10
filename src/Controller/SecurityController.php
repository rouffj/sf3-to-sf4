<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class SecurityController
{
    /**
     * @Route("/login", name="app_security_login", methods={"POST"})
     */
    public function login()
    {
        throw new \LogicException('The "security.firewalls.main.form_login.check_path" seems wrong in "security.yaml".');
    }

    /**
     * @Route("/logout", name="app_security_logout", methods={"GET"})
     */
    public function logout()
    {
        throw new \LogicException('The "security.firewalls.main.logout.path" seems wrong in "security.yaml".');
    }
}

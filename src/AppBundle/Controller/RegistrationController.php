<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends \FOS\UserBundle\Controller\RegistrationController
{
    public function registerAction(Request $request)
    {
        if ($this->getUser()) return $this->redirectToRoute('homepage');
        return parent::registerAction($request);
    }
}

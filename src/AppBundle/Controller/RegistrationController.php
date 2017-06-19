<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends \FOS\UserBundle\Controller\RegistrationController
{
    /**
     * @Route("/login/{_locale}", name="register", defaults={"_locale": "fr"}, requirements={
     *     "_locale": "fr|en"
     * })
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        if ($this->getUser()) return $this->redirectToRoute('homepage');
        return parent::registerAction($request);
    }
}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends \FOS\UserBundle\Controller\SecurityController
{
    /**
     * @Route("/login/{_locale}", name="login", defaults={"_locale": "fr"}, requirements={
     *     "_locale": "fr|en"
     * })
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        if ($this->getUser()) return $this->redirectToRoute('homepage');
        return parent::loginAction($request);
    }

}


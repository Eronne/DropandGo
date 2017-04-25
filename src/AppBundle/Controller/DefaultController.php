<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/{_locale}", name="homepage", defaults={"_locale": "fr"}, requirements={
     *     "_locale": "fr|en"
     * })
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }



    /**
     * @Route("/{_locale}/help", name="help", defaults={"_locale": "fr"}, requirements={
     *     "_locale": "fr|en"
     * })
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function helpAction(Request $request)
    {
        return $this->render('default/help.html.twig');
    }



    /**
     * @Route("/storage", name="storage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function storageAction(Request $request)
    {
        return $this->render('default/storage.html.twig');
    }
}

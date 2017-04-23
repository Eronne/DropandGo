<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\Upload;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }



    /**
     * @Route("/help", name="help")
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

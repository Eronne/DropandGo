<?php

namespace AppBundle\Controller;

use AppBundle\Form\UploadType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @Route("/storage", name="storage", methods={"GET"})
     */
    public function storageAction()
    {
        //For listing
        $files = $this->getDoctrine()->getRepository('AppBundle:File')->findBy(array('deleted' => 'true'));
        $files = array_map(function ($elt) {
            $elt->setPath(pathinfo($elt->getPath(), PATHINFO_BASENAME));

            return $elt;
        }, $files);

        return $this->render('default/storage.html.twig', ['files' => $files]);
    }


    /**
     * @Route("/upload", name="upload", methods={"POST"})
     * @param Request $request
     * @return JsonResponse|FormInterface
     */
    public function uploadAction(Request $request)
    {
        $form = $this->createForm(UploadType::class);
        $form->handleRequest($request);
        //Todo: add isValid for assets
        if ($form->isSubmitted()) {
            $file = $form->getData();
            $this->getDoctrine()
                ->getRepository('AppBundle:File')
                ->store($file);

            return new JsonResponse(["key" => $file->getKey()], 201);
        }

        return $form;
    }


    /**
     * @Route("download/{key}", name="download", methods={"GET"})
     * @param string $key
     * @return Response
     * @throws NotFoundHttpException
     */
    public function downloadAction($key)
    {
        $file = $this->getDoctrine()->getRepository('AppBundle:File')->findOneBy(['key' => $key]);

        if (!$file) {
            throw $this->createNotFoundException('File does not exists.');
        }

        if ($file->isDeleted()) {
            return new JsonResponse(["File is deleted."], 410);
        }

        $file = new File($file->getPath());
        $response = new StreamedResponse(function () use ($file) {
            $handle = fopen($file->getRealPath(), 'r');
            while (!feof($handle)) {
                $buffer = fread($handle, 1024);
                echo $buffer;
                flush();
            }
            fclose($handle);
        }, 200);

        $headerDisposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $file->getFilename()
        );
        $response->headers->set('Content-Type', $file->getMimeType());
        $response->headers->set('Content-disposition', $headerDisposition);

        return $response;
    }


    /**
     * @Route("/{key}", name="delete", methods={"DELETE"})
     * @param string $key
     * @return JsonResponse
     * @throws NotFoundHttpException
     */
    public function deleteAction($key)
    {
        $fileDb = $this->getDoctrine()->getRepository('AppBundle:File')->findOneBy(['key' => $key]);
        if (!$fileDb) {
            throw $this->createNotFoundException('File does not exists.');
        }

        if ($fileDb->isDeleted()) {
            return new JsonResponse(["File is deleted."], 410);
        }

        $fileDb->setDeleted(true);
        $this->getDoctrine()->getManager()->flush();

        try {
            $file = new File($fileDb->getPath());
            unlink($file->getRealPath());
        } catch (FileNotFoundException $e) {
        }

        return new JsonResponse([], 204);
    }
}

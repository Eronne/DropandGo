<?php

namespace AppBundle\EventListener;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class ViewListener
{
    /**
     * @param GetResponseForControllerResultEvent $event
     *
     * @return JsonResponse
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();
        if (!$result instanceof FormInterface) {
            return;
        }

        $bodyError = [];
        $statusCode = 200;
        if ($formErrors = $result->getErrors(true)) {
            /** @var FormError $formError */
            foreach ($formErrors as $formError) {
                $bodyError[] = $formError->getMessage();
            }

            $statusCode = 400;
        }

        $event->setResponse(new JsonResponse($bodyError, $statusCode));
    }
}
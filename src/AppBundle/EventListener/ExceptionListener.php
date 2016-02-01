<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception->getPrevious() instanceof AccessDeniedException) {
            $event->setResponse(
                new Response('Access Denied', Response::HTTP_FORBIDDEN)
            );
        }
    }
}

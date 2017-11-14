<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Symfony\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class CorsListener
{
    /**
     * @param GetResponseEvent $event
     */
    public function onKernelResponse(GetResponseEvent $event)
    {
        $path = $event->getRequest()->getRequestUri();

        if (preg_match('/^\/api/', $path)) {
            $event->getResponse()->headers->set('Access-Control-Allow-Origin', '*');
        }
    }
}
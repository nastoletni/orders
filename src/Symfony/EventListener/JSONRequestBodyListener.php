<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Symfony\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class JSONRequestBodyListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ('application/json' == $request->headers->get('Content-Type')) {
            $json = json_decode($request->getContent(), true);

            if (is_array($json)) {
                $request->request->replace($json);
            }
        }
    }
}
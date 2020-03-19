<?php

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseSubscriber implements EventSubscriberInterface
{
    /** @var LoggerInterface $logger */
    private $logger;

    /**
     * Class Constructor.
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $this->logger->info(sprintf(
            'Outgoing Response: %s %s',
            $event->getRequest()->get('_route'),
            $event->getResponse()
        ));
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.response' => 'onKernelResponse',
        ];
    }
}

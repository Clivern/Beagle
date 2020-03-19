<?php

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Event\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Request Event Listener.
 */
class RequestListener
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

    public function onKernelRequest(RequestEvent $event)
    {
        $this->logger->info(sprintf(
            'Incoming Request: %s:%s %s',
            $event->getRequest()->getMethod(),
            $event->getRequest()->get('_route'),
            $event->getRequest()->getUri()
        ));
    }
}

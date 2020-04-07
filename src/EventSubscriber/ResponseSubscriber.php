<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * ResponseSubscriber Class.
 */
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
        if ('application/json' === $event->getResponse()->headers->get('content-type', '')) {
            $this->logger->info(sprintf(
                'Outgoing response with status code %s: %s %s',
                $event->getResponse()->getStatusCode(),
                $event->getRequest()->get('_route'),
                $event->getResponse()
            ));
        } else {
            $this->logger->info(sprintf(
                'Outgoing response with status code %s: %s <html>...',
                $event->getResponse()->getStatusCode(),
                $event->getRequest()->get('_route')
            ));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.response' => 'onKernelResponse',
        ];
    }
}

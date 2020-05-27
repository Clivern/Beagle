<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\EventSubscriber;

use App\Utils\CanonicalLogger;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * RequestSubscriber Class.
 */
class RequestSubscriber implements EventSubscriberInterface
{
    /** @var LoggerInterface */
    private $logger;

    /** @var CanonicalLogger */
    private $canonicalLogger;

    /**
     * Class Constructor.
     */
    public function __construct(
        LoggerInterface $logger,
        CanonicalLogger $canonicalLogger
    ) {
        $this->logger = $logger;
        $this->canonicalLogger = $canonicalLogger;
    }

    /**
     * {@inheritdoc}
     */
    public function onKernelRequest(RequestEvent $event)
    {
        $this->logger->info(sprintf(
            'Incoming [%s] request, route [%s] and uri [%s]',
            $event->getRequest()->getMethod(),
            $event->getRequest()->get('_route'),
            $event->getRequest()->getUri()
        ));

        $this->canonicalLogger->info('Request started', [
            'http_method' => $event->getRequest()->getMethod(),
            'http_path' => $event->getRequest()->getUri(),
            'http_route' => $event->getRequest()->get('_route'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}

<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\EventSubscriber;

use App\Module\Metrics\PrometheusRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * MetricsSubscriber Class.
 */
class MetricsSubscriber implements EventSubscriberInterface
{
    /** @var LoggerInterface */
    private $logger;

    /** @var float */
    private $requestTime;

    /** @var float */
    private $responseTime;

    /** @var PrometheusRegistry */
    private $registry;

    /**
     * Class Constructor.
     */
    public function __construct(
        LoggerInterface $logger,
        PrometheusRegistry $registry
    ) {
        $this->logger = $logger;
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function onKernelRequest(ControllerEvent $event)
    {
        $this->requestTime = (int) (microtime(true) * 1000);
    }

    /**
     * {@inheritdoc}
     */
    public function onKernelResponse(ResponseEvent $event)
    {
        $this->responseTime = (int) (microtime(true) * 1000);

        $counter = $this->registry->getCollector()->getOrRegisterCounter(
            '',
            'app_http_requests',
            'HTTP Requests',
            ['method', 'route', 'status']
        );
        $counter->incBy(1, [
            $event->getRequest()->getMethod(),
            $event->getRequest()->get('_route'),
            $event->getResponse()->getStatusCode(),
        ]);

        $histogram = $this->registry->getCollector()->getOrRegisterHistogram(
            '',
            'app_request_duration',
            'Request Duration',
            ['method', 'route']
        );
        $histogram->observe($this->responseTime - $this->requestTime, [
            $event->getRequest()->getMethod(),
            $event->getRequest()->get('_route'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelRequest', 1],
            KernelEvents::RESPONSE => ['onKernelResponse', 1],
        ];
    }
}

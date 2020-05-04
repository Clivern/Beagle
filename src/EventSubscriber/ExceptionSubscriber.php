<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\EventSubscriber;

use App\Exception\ClientError;
use App\Exception\ServerError;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * ExceptionSubscriber Class.
 */
class ExceptionSubscriber implements EventSubscriberInterface
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * Class Constructor.
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        if ($event->getThrowable() instanceof ServerError) {
            return $this->handleServerError($event, $event->getThrowable());
        } elseif ($event->getThrowable() instanceof ClientError) {
            return $this->handleClientError($event, $event->getThrowable());
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    /**
     * Handle ServerError Exception.
     *
     * @return void
     */
    private function handleServerError(ExceptionEvent $event, ServerError $e)
    {
        $event->setResponse(new JsonResponse([
            'errorCode' => $e->getErrorCode(),
            'errorMessage' => $e->getMessage(),
        ], $e->getHttpCode()));
    }

    /**
     * Handle ClientError Exception.
     *
     * @param ServerError $e
     *
     * @return void
     */
    private function handleClientError(ExceptionEvent $event, ClientError $e)
    {
        $event->setResponse(new JsonResponse([
            'errorCode' => $e->getErrorCode(),
            'errorMessage' => $e->getMessage(),
        ], $e->getHttpCode()));
    }
}

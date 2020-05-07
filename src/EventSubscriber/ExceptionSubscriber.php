<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\EventSubscriber;

use App\Exception\ClientError;
use App\Exception\ErrorCodes;
use App\Exception\ServerError;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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

        return $this->handleUnexpectedError($event, $event->getThrowable());
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
        $this->logger->error(sprintf(
            'Exception with errorCode [%s] errorMessage [%s] httpCode [%s] thrown: %s',
            $e->getErrorCode(),
            $e->getMessage(),
            $e->getHttpCode(),
            $e->getTraceAsString()
        ));

        $event->setResponse(new JsonResponse([
            'errorCode' => $e->getErrorCode(),
            'errorMessage' => $e->getMessage(),
            'correlationId' => $event->getRequest()->headers->get('X-Correlation-ID', ''),
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
        $this->logger->debug(sprintf(
            'Exception with errorCode [%s] errorMessage [%s] httpCode [%s] thrown: %s',
            $e->getErrorCode(),
            $e->getMessage(),
            $e->getHttpCode(),
            $e->getTraceAsString()
        ));

        $event->setResponse(new JsonResponse([
            'errorCode' => $e->getErrorCode(),
            'errorMessage' => $e->getMessage(),
            'correlationId' => $event->getRequest()->headers->get('X-Correlation-ID', ''),
        ], $e->getHttpCode()));
    }

    /**
     * Handle Exception.
     *
     * @param Exception $e
     *
     * @return void
     */
    private function handleUnexpectedError(ExceptionEvent $event, $e)
    {
        $this->logger->error(sprintf(
            'Exception with errorCode [%s] errorMessage [%s] httpCode [%s] thrown: %s',
            ErrorCodes::ERROR_002,
            $e->getMessage(),
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $e->getTraceAsString()
        ));

        $event->setResponse(new JsonResponse([
            'errorCode' => ErrorCodes::ERROR_002,
            'errorMessage' => $e->getMessage(),
            'correlationId' => $event->getRequest()->headers->get('X-Correlation-ID', ''),
        ], Response::HTTP_INTERNAL_SERVER_ERROR));
    }
}

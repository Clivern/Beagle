<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\EventSubscriber;

use App\Annotation\Before;
use App\Annotation\Controller\Response;
use Doctrine\Common\Annotations\Reader;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use ReflectionException;
use RuntimeException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * ControllerSubscriber Class.
 */
class ControllerArgumentSubscriber implements EventSubscriberInterface
{
    /** @var Reader $annotationReader */
    private $annotationReader;

    /** @var LoggerInterface $logger */
    private $logger;

    /**
     * Class Constructor.
     */
    public function __construct(Reader $annotationReader, LoggerInterface $logger)
    {
        $this->annotationReader = $annotationReader;
        $this->logger = $logger;
    }

    public function onKernelControllerArguments(ControllerArgumentsEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $controllers = $event->getController();

        if (!\is_array($controllers)) {
            return;
        }

        $this->handleAnnotation($controllers, $event);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER_ARGUMENTS => 'onKernelControllerArguments',
        ];
    }

    private function handleAnnotation(iterable $controllers, ControllerArgumentsEvent $event): void
    {
        list($controller, $method) = $controllers;

        try {
            $controller = new ReflectionClass($controller);
        } catch (ReflectionException $e) {
            throw new RuntimeException('Failed to read annotation!');
        }

        $this->handleMethodAnnotation($controller, $method, $event);
    }

    private function handleMethodAnnotation(
        ReflectionClass $controller,
        string $method,
        ControllerArgumentsEvent $event
    ): void {
        $method = $controller->getMethod($method);

        $annotations = $this->annotationReader->getMethodAnnotations($method);

        $arguments = $event->getArguments();

        // Override last argument extras
        $arguments[\count($arguments) - 1] = ['status' => 'NOT_OK'];
        $event->setArguments($arguments);

        $namedArguments = $event->getRequest()->attributes->all();

        // var_dump($namedArguments);

        foreach ($annotations as $annotation) {
            if ($annotation instanceof Before) {
                // var_dump($annotation);
            }

            if ($annotation instanceof Response) {
                // var_dump($annotation);
            }
        }
    }
}

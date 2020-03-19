<?php

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Event\Listener;

use App\Annotation\Model as ModelAnnotation;
use Doctrine\Common\Annotations\Reader;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use ReflectionException;
use RuntimeException;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

/**
 * Annotations Listener.
 */
class AnnotationsListener
{
    private $annotationReader;

    /** @var LoggerInterface $logger */
    private $logger;

    public function __construct(Reader $annotationReader, LoggerInterface $logger)
    {
        $this->annotationReader = $annotationReader;
        $this->logger = $logger;
    }

    public function onKernelController(ControllerEvent $event): void
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

    private function handleAnnotation(iterable $controllers, ControllerEvent $event): void
    {
        list($controller, $method) = $controllers;

        try {
            $controller = new ReflectionClass($controller);
        } catch (ReflectionException $e) {
            throw new RuntimeException('Failed to read annotation!');
        }

        $this->handleClassAnnotation($controller, $event);
        $this->handleMethodAnnotation($controller, $method, $event);
    }

    private function handleClassAnnotation(ReflectionClass $controller, ControllerEvent $event): void
    {
        $annotation = $this->annotationReader->getClassAnnotation($controller, ModelAnnotation::class);

        if ($annotation instanceof ModelAnnotation) {
            print_r($annotation);
            var_dump($event->getRequest()->getMethod());
        }
    }

    private function handleMethodAnnotation(ReflectionClass $controller, string $method, ControllerEvent $event): void
    {
        $method = $controller->getMethod($method);
        $annotation = $this->annotationReader->getMethodAnnotation($method, ModelAnnotation::class);

        if ($annotation instanceof ModelAnnotation) {
            print_r($annotation);
            var_dump($event->getRequest()->getMethod());
        }
    }
}

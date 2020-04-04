<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\EventSubscriber;

use App\Annotation\Before;
use Doctrine\Common\Annotations\Reader;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use ReflectionException;
use RuntimeException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

/**
 * AnnotationsSubscriber Class.
 */
class AnnotationsSubscriber implements EventSubscriberInterface
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

    public function onKernelController(ControllerEvent $event)
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
            'kernel.controller' => 'onKernelController',
        ];
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
        $annotation = $this->annotationReader->getClassAnnotation($controller, Before::class);

        if ($annotation instanceof Before) {
            // print_r($annotation);
            // var_dump($event->getRequest()->getMethod());
        }
    }

    private function handleMethodAnnotation(ReflectionClass $controller, string $method, ControllerEvent $event): void
    {
        $method = $controller->getMethod($method);
        $annotation = $this->annotationReader->getMethodAnnotation($method, Before::class);

        if ($annotation instanceof Before) {
            // print_r($annotation);
            // var_dump($event->getRequest()->getMethod());
        }
    }
}

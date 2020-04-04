<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * ConsoleErrorSubscriber Class.
 */
class ConsoleErrorSubscriber implements EventSubscriberInterface
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

    public function onConsoleError(ConsoleErrorEvent $event)
    {
        $this->logger->error(sprintf(
            'Error: [%s] while running command: %s',
            $event->getError()->getMessage(),
            json_encode($event->getInput()->getArguments())
        ));
    }

    public static function getSubscribedEvents()
    {
        return [
            'console.error' => 'onConsoleError',
        ];
    }
}

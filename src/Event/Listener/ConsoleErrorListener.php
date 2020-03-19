<?php

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Event\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Event\ConsoleErrorEvent;

/**
 * Console Error Event Listener.
 */
class ConsoleErrorListener
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
}

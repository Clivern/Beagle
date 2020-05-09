<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Module\Async;

use App\Contract\MessageBroker as MessageBrokerContract;
use App\Contract\Messsage as MesssageContract;
use Psr\Log\LoggerInterface;

/**
 * Dispatcher Class.
 */
class Dispatcher
{
    /** @var LoggerInterface */
    private $logger;

    /** @var MessageBrokerContract */
    private $messageBroker;

    /**
     * Class Constructor.
     */
    public function __construct(
        LoggerInterface $logger,
        MessageBrokerContract $messageBroker
    ) {
        $this->logger = $logger;
        $this->messageBroker = $messageBroker;
    }

    /**
     * Dispatch Message to Workers.
     */
    public function dispatch(MesssageContract $message): array
    {
        $result = [];

        // ~

        return $result;
    }

    /**
     * Run Message Received.
     */
    public function run(string $message): array
    {
        $result = [];

        // ~

        return $result;
    }
}

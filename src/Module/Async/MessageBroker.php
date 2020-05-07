<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Module\Async;

use App\Contract\MessageBroker as MessageBrokerContract;
use Psr\Log\LoggerInterface;

/**
 * MessageBroker Class.
 */
class MessageBroker implements MessageBrokerContract
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
}

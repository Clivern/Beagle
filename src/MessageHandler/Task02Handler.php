<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\MessageHandler;

use App\Message\Task02;
use App\Utils\Config;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class Task02Handler.
 */
class Task02Handler implements MessageHandlerInterface
{
    /** @var LoggerInterface */
    private $logger;

    /** @var MessageBusInterface */
    private $messageBus;

    /** @var Config */
    private $config;

    /**
     * Class Constructor.
     */
    public function __construct(
        LoggerInterface $logger,
        Config $config,
        MessageBusInterface $messageBus
    ) {
        $this->logger = $logger;
        $this->messageBus = $messageBus;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Task02 $task)
    {
        var_dump($task->getPayload());
    }
}

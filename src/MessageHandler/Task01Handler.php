<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\MessageHandler;

use App\Message\Task01;
use App\Message\Task02;
use App\Utils\Config;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

/**
 * Class Task01Handler.
 */
class Task01Handler implements MessageHandlerInterface
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
    public function __invoke(Task01 $task)
    {
        var_dump($task->getPayload());

        $this->messageBus->dispatch(new Task02('Hey Task2!'));
        $this->messageBus->dispatch(new Task02('Hey Task2 After 5 Seconds!'), [
            new DelayStamp(5000),
        ]);
    }
}

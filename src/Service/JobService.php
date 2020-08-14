<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Service;

use App\Entity\Job;
use App\Message\Task;
use App\MessageHandler\TaskHandler;
use App\Repository\JobRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

/**
 * Job Service.
 */
class JobService
{
    /** @var JobRepository */
    private $jobRepository;

    /** @var LoggerInterface */
    private $logger;

    /** @var MessageBusInterface */
    private $messageBus;

    /**
     * Class Constructor.
     */
    public function __construct(
        JobRepository $jobRepository,
        LoggerInterface $logger,
        MessageBusInterface $messageBus
    ) {
        $this->jobRepository = $jobRepository;
        $this->logger = $logger;
        $this->messageBus = $messageBus;
    }

    /**
     * Dispatch Async Job.
     */
    public function dispatch(string $handler, array $args, int $time = 0): Job
    {
        $args[TaskHandler::HANDLER_KEY] = $handler;

        $options = [];

        if ($time) {
            $options[] = new DelayStamp($time);
        }

        $this->messageBus->dispatch(new Task($args), $options);

        return new Job();
    }
}

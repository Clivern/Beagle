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
use App\Utils\Config;
use DateTime;
use DateTimeZone;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
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
        MessageBusInterface $messageBus,
        Config $config
    ) {
        $this->jobRepository = $jobRepository;
        $this->logger = $logger;
        $this->messageBus = $messageBus;
        $this->config = $config;
    }

    /**
     * Dispatch Async Job.
     */
    public function dispatchOne(string $handler, array $args, int $time = 0): Job
    {
        $now = new DateTime('NOW', new DateTimeZone($this->config->get('APP_TIMEZONE', 'UTC')));
        $args[TaskHandler::HANDLER_KEY] = $handler;

        $options = [];

        if ($time) {
            $options[] = new DelayStamp($time);
        }

        $uuid = Uuid::uuid4()->toString();

        $jobId = $this->jobRepository->insertOne([
            'uuid' => $uuid,
            'handler' => $handler,
            'options' => json_encode($options),
            'args' => json_encode($args),
            'status' => Job::PENDING,
            'result' => json_encode(['error' => '']),
            'createdAt' => $now,
            'updatedAt' => $now,
        ]);

        $args[TaskHandler::JOB_ID] = $jobId;

        $this->messageBus->dispatch(new Task($args), $options);

        return $this->jobRepository->getOneByID($jobId);
    }
}

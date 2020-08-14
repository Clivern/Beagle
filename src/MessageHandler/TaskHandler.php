<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\MessageHandler;

use App\Contract\AsyncHandler;
use App\Entity\Job;
use App\Exception\ServerError;
use App\Message\Task;
use App\Repository\JobRepository;
use App\Utils\Config;
use DateTime;
use DateTimeZone;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class TaskHandler.
 */
class TaskHandler implements MessageHandlerInterface
{
    /** Handler Key */
    const HANDLER_KEY = 'internal.handler';

    /** Job ID */
    const JOB_ID = 'internal.jobId';

    /** @var LoggerInterface */
    private $logger;

    /** @var ServiceLocator */
    private $serviceLocator;

    /** @var JobRepository */
    private $jobRepository;

    /**
     * Class Constructor.
     */
    public function __construct(
        LoggerInterface $logger,
        ServiceLocator $serviceLocator,
        JobRepository $jobRepository,
        Config $config
    ) {
        $this->logger = $logger;
        $this->serviceLocator = $serviceLocator;
        $this->jobRepository = $jobRepository;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Task $task)
    {
        $handler = $task->getPayload()[self::HANDLER_KEY];
        $jobId = $task->getPayload()[self::JOB_ID];

        $this->updateJobStatus(
            $jobId,
            Job::IN_PROGRESS
        );

        if (!$this->serviceLocator->has($handler) || !($this->serviceLocator->get($handler) instanceof AsyncHandler)) {
            $this->logger->error(sprintf(
                'Error! Task failed due to Invalid AsyncHandler %s: %s',
                $handler,
                json_encode($task->getPayload())
            ));

            $this->updateJobStatus(
                $jobId,
                Job::FAILED,
                json_encode(['error' => 'Internal Server Error!'])
            );

            throw new Exception(sprintf('Error! Invalid AsyncHandler %s', $handler));
        }

        $this->logger->info(sprintf(
            'Execute Task with AsyncHandler %s: %s',
            $handler,
            json_encode($task->getPayload())
        ));

        try {
            $result = $this->serviceLocator->get($handler)->invoke($task->getPayload())->callback();
        } catch (Exception $e) {
            $this->logger->error(sprintf(
                'Task with AsyncHandler %s and payload %s failed: %s',
                $handler,
                json_encode($task->getPayload()),
                $e->getMessage()
            ));

            $this->updateJobStatus(
                $jobId,
                Job::FAILED,
                json_encode(['error' => sprintf('Job failed with message %s!', $e->getMessage())])
            );

            throw new ServerError($e->getMessage());
        }

        $this->updateJobStatus(
            $jobId,
            Job::SUCCEED
        );

        return $result;
    }

    /**
     * Update Job Status.
     */
    private function updateJobStatus(int $jobId, string $status, string $result = ''): bool
    {
        $now = new DateTime('NOW', new DateTimeZone($this->config->get('APP_TIMEZONE', 'UTC')));
        $result = empty($result) ? json_encode(['error' => '']) : $result;

        return $this->jobRepository->updateOneById($jobId, [
            'status' => $status,
            'result' => $result,
            'runAt' => $now,
            'updatedAt' => $now,
        ]);
    }
}

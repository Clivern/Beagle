<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\MessageHandler;

use App\Contract\AsyncHandler;
use App\Exception\ServerError;
use App\Message\Task;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class TaskHandler.
 */
class TaskHandler implements MessageHandlerInterface
{
    /** Handler Key */
    const HANDLER_KEY = '__internal_handler';

    /** @var LoggerInterface */
    private $logger;

    /** @var ContainerInterface */
    private $container;

    /**
     * Class Constructor.
     */
    public function __construct(
        LoggerInterface $logger,
        ContainerInterface $container
    ) {
        $this->logger = $logger;
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Task $task)
    {
        $handler = $task->getPayload()[self::HANDLER_KEY];

        if (!$this->container->has($handler) || !($this->container->get($handler) instanceof AsyncHandler)) {
            $this->logger->error(sprintf(
                'Error! Task failed due to Invalid AsyncHandler %s: %s',
                $handler,
                json_encode($task->getPayload())
            ));

            throw new Exception(sprintf('Error! Invalid AsyncHandler %s', $handler));
        }

        $this->logger->info(sprintf(
            'Execute Task with AsyncHandler %s: %s',
            $handler,
            json_encode($task->getPayload())
        ));

        try {
            $result = $this->container->get($handler)->__invoke($task->getPayload());
        } catch (Exception $e) {
            $this->logger->error(sprintf(
                'Task with AsyncHandler %s and payload %s failed: %s',
                $handler,
                json_encode($task->getPayload()),
                $e->getMessage()
            ));

            // Let symfony messenger know about the failure
            throw new ServerError($e->getMessage());
        }

        return $result;
    }
}

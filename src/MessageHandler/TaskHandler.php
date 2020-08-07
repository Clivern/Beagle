<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\MessageHandler;

use App\Message\Task;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class TaskHandler.
 */
class TaskHandler implements MessageHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(Task $task)
    {
        var_dump($task->getPayload());
    }
}

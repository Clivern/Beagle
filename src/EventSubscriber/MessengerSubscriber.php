<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Symfony\Component\Messenger\Event\WorkerRunningEvent;
use Symfony\Component\Messenger\Event\WorkerStartedEvent;
use Symfony\Component\Messenger\Event\WorkerStoppedEvent;

/**
 * MessengerSubscriber Class.
 */
class MessengerSubscriber implements EventSubscriberInterface
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

    public function onWorkerMessageFailedEvent(WorkerMessageFailedEvent $event)
    {
        $this->logger->info(sprintf(
            'Event triggered %s',
            \get_class($event)
        ));
    }

    public function onWorkerStartedEvent(WorkerStartedEvent $event)
    {
        $this->logger->info(sprintf(
            'Event triggered %s',
            \get_class($event)
        ));
    }

    public function onWorkerMessageReceivedEvent(WorkerMessageReceivedEvent $event)
    {
        $this->logger->info(sprintf(
            'Event triggered %s',
            \get_class($event)
        ));
    }

    public function onSendMessageToTransportsEvent(SendMessageToTransportsEvent $event)
    {
        $this->logger->info(sprintf(
            'Event triggered %s',
            \get_class($event)
        ));
    }

    public function onWorkerMessageHandledEvent(WorkerMessageHandledEvent $event)
    {
        $this->logger->info(sprintf(
            'Event triggered %s',
            \get_class($event)
        ));
    }

    public function onWorkerRunningEvent(WorkerRunningEvent $event)
    {
        $this->logger->info(sprintf(
            'Event triggered %s',
            \get_class($event)
        ));
    }

    public function onWorkerStoppedEvent(WorkerStoppedEvent $event)
    {
        $this->logger->info(sprintf(
            'Event triggered %s',
            \get_class($event)
        ));
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            WorkerMessageFailedEvent::class => 'onWorkerMessageFailedEvent',
            WorkerStartedEvent::class => 'onWorkerStartedEvent',
            WorkerMessageReceivedEvent::class => 'onWorkerMessageReceivedEvent',
            SendMessageToTransportsEvent::class => 'onSendMessageToTransportsEvent',
            WorkerMessageHandledEvent::class => 'onWorkerMessageHandledEvent',
            WorkerRunningEvent::class => 'onWorkerRunningEvent',
            WorkerStoppedEvent::class => 'onWorkerStoppedEvent',
        ];
    }
}

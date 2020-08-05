<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\MessageHandler;

use App\Message\SmsNotification;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class SmsNotificationHandler.
 */
class SmsNotificationHandler implements MessageHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(SmsNotification $message)
    {
        var_dump($message->getContent());
    }
}

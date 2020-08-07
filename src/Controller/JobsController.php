<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Controller;

use App\Message\SmsNotification;
use App\Module\Validator;
use App\Utils\Config;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Job Controller.
 *
 * @Route("/api/v1/job")
 */
class JobsController extends AbstractController
{
    /** @var LoggerInterface */
    private $logger;

    /** @var Validator */
    private $validator;

    /** @var MessageBusInterface */
    private $messageBus;

    /** @var Config */
    private $config;

    /**
     * Class Constructor.
     */
    public function __construct(
        LoggerInterface $logger,
        Validator $validator,
        Config $config,
        MessageBusInterface $messageBus
    ) {
        $this->logger = $logger;
        $this->validator = $validator;
        $this->messageBus = $messageBus;
        $this->config = $config;
    }

    /**
     * @Route("/", methods={"POST"}, name="job.createAction")
     */
    public function createAction(Request $request)
    {
        $data = $request->getContent();

        $this->messageBus->dispatch(new SmsNotification('Hello World!'));

        $this->messageBus->dispatch(new SmsNotification('Hello World After 5 Seconds!'), [
            new DelayStamp(5000),
        ]);

        return $this->json([], Response::HTTP_CREATED);
    }
}

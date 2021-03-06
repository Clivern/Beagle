<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Controller;

use App\Module\Validator;
use App\Service\JobService;
use App\Utils\Config;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    /** @var JobService */
    private $asyncJob;

    /** @var Config */
    private $config;

    /**
     * Class Constructor.
     */
    public function __construct(
        LoggerInterface $logger,
        Validator $validator,
        Config $config,
        JobService $asyncJob
    ) {
        $this->logger = $logger;
        $this->validator = $validator;
        $this->asyncJob = $asyncJob;
        $this->config = $config;
    }

    /**
     * @Route("", methods={"POST"}, name="job.createAction")
     */
    public function createAction(Request $request)
    {
        $data = $request->getContent();

        var_dump($this->asyncJob->dispatch(
            'App\AsyncHandler\TestHandler1',
            ['key' => 'hey']
        ));

        var_dump($this->asyncJob->dispatch(
            'App\AsyncHandler\TestHandler2',
            ['key' => 'hey after 5 sec'],
            5000
        ));

        return $this->json([], Response::HTTP_CREATED);
    }
}

<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Controller;

use App\Annotation\Before;
use App\Annotation\Controller\Response;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Health Controller.
 */
class HealthController extends AbstractController
{
    /** @var LoggerInterface $logger */
    private $logger;

    /**
     * Class Constructor.
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("_health", name="app.health")
     * @Before(namespace="namespace2", version=2, types={"json","xml"})
     * @Response(type="json")
     *
     * @param mixed $status
     */
    public function index(Request $request, $status = 'ok')
    {
        $this->logger->info('Application is up!');

        return $this->json(['status' => $status]);
    }
}

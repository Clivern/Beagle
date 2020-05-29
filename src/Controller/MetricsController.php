<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Controller;

use App\Module\Metrics\PrometheusRegistry;
use App\Utils\Config;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Metrics Controller.
 */
class MetricsController extends AbstractController
{
    /** @var LoggerInterface */
    private $logger;

    /** @var PrometheusRegistry */
    private $registry;

    /** @var Config */
    private $config;

    /**
     * Class Constructor.
     */
    public function __construct(
        LoggerInterface $logger,
        Config $config,
        PrometheusRegistry $registry
    ) {
        $this->logger = $logger;
        $this->registry = $registry;
        $this->config = $config;
    }

    /**
     * @Route("/_metrics", methods={"GET"}, name="metricsAction")
     */
    public function metricsAction(Request $request)
    {
        return new Response(
            $this->registry->render(),
            Response::HTTP_OK,
            ['content-type' => 'text/plain']
        );
    }

    /**
     * @Route("/_metrics/{name}", methods={"GET"}, name="metricsIncAction")
     *
     * @param mixed $name
     */
    public function metricsIncAction(Request $request, $name)
    {
        // $ curl -X GET http://127.0.0.1:8000/_metrics/app_action_xxxxxx
        $this->registry->getCollector()->getOrRegisterCounter(
            '',
            $name,
            'Certain Action'
        )->inc();

        return $this->json([]);
    }
}

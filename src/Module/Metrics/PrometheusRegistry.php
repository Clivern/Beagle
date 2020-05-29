<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Module\Metrics;

use App\Utils\Config;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Psr\Log\LoggerInterface;

/**
 * PrometheusRegistry Module.
 */
class PrometheusRegistry
{
    /** @var LoggerInterface */
    private $logger;

    /** @var Config */
    private $config;

    /**
     * Class Constructor.
     */
    public function __construct(
        LoggerInterface $logger,
        Config $config
    ) {
        $this->logger = $logger;
        $this->config = $config;
    }

    /**
     * Get Collector.
     */
    public function getCollector()
    {
        $adapter = new \Prometheus\Storage\Redis([
            'host' => $this->config->get('redis_host', '127.0.0.1'),
            'port' => (int) $this->config->get('redis_port', 6379),
            'password' => $this->config->get('redis_password', null),
            'timeout' => 0.1, // in seconds
            'read_timeout' => '10', // in seconds
            'persistent_connections' => false,
        ]);

        return new CollectorRegistry($adapter);
    }

    /**
     * Render Metrics.
     */
    public function render(): string
    {
        $renderer = new RenderTextFormat();

        return $renderer->render($this->getCollector()->getMetricFamilySamples());
    }
}

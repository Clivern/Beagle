<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\AsyncHandler;

use App\Contract\AsyncHandler;
use App\Utils\Config;
use Psr\Log\LoggerInterface;

/**
 * Class TestHandler2.
 */
class TestHandler2 implements AsyncHandler
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
     * {@inheritdoc}
     */
    public function __invoke(array $args)
    {
        var_dump(static::class);
        var_dump(json_encode($args));
    }
}

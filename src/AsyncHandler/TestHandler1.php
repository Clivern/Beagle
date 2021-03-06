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
 * Class TestHandler1.
 */
class TestHandler1 implements AsyncHandler
{
    /** @var LoggerInterface */
    private $logger;

    /** @var Config */
    private $config;

    /** @var array */
    private $args;

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
    public function invoke(array $args): AsyncHandler
    {
        $this->args = $args;
        var_dump(static::class);
        var_dump(json_encode($args));

        $this->args['instance.scope.var'] = 'something';

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function onSuccess()
    {
        // $this->args["instance.scope.var"] available here
        var_dump($this->args);
        var_dump('Yay!');
    }

    /**
     * {@inheritdoc}
     */
    public function onFailure()
    {
        // $this->args["instance.scope.var"] available here
        var_dump($this->args);
        var_dump('Cleanup!');
    }
}

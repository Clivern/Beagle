<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Utils;

use Psr\Log\LoggerInterface;

/**
 * CanonicalLogger Utils.
 *
 * @see https://stripe.com/blog/canonical-log-lines
 */
class CanonicalLogger
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * Class Constructor.
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * System is unusable.
     *
     * @return void
     */
    public function emergency(string $action, array $flags = [])
    {
        $this->logger->emergency($this->format(
            $action,
            $flags
        ));
    }

    /**
     * Action must be taken immediately.
     *
     * @return void
     */
    public function alert(string $action, array $flags = [])
    {
        $this->logger->alert($this->format(
            $action,
            $flags
        ));
    }

    /**
     * Critical conditions.
     *
     * @return void
     */
    public function critical(string $action, array $flags = [])
    {
        $this->logger->critical($this->format(
            $action,
            $flags
        ));
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @return void
     */
    public function error(string $action, array $flags = [])
    {
        $this->logger->error($this->format(
            $action,
            $flags
        ));
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * @return void
     */
    public function warning(string $action, array $flags = [])
    {
        $this->logger->warning($this->format(
            $action,
            $flags
        ));
    }

    /**
     * Normal but significant events.
     *
     * @return void
     */
    public function notice(string $action, array $flags = [])
    {
        $this->logger->notice($this->format(
            $action,
            $flags
        ));
    }

    /**
     * Interesting events.
     *
     * @return void
     */
    public function info(string $action, array $flags = [])
    {
        $this->logger->info($this->format(
            $action,
            $flags
        ));
    }

    /**
     * Detailed debug information.
     *
     * @return void
     */
    public function debug(string $action, array $flags = [])
    {
        $this->logger->debug($this->format(
            $action,
            $flags
        ));
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     *
     * @return void
     */
    public function log($level, string $action, array $flags = [])
    {
        $this->logger->log($level, $this->format(
            $action,
            $flags
        ));
    }

    /**
     * Format logs to be cononical.
     *
     * @return string
     */
    private function format(string $action, array $flags = [])
    {
        ksort($flags);

        $result = $action;

        foreach ($flags as $key => $value) {
            $result .= " {$key}={$value}";
        }

        return $result;
    }
}

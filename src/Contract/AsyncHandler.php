<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Contract;

/**
 * AsyncHandler Interface.
 */
interface AsyncHandler
{
    /**
     * Execute Handler.
     */
    public function invoke(array $args): self;

    /**
     * Triggered if job succeeded.
     */
    public function onSuccess();

    /**
     * Triggered if job failed.
     */
    public function onFailure();
}

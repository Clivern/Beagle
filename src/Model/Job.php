<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Model;

/**
 * Job Model.
 */
class Job
{
    /** @var string */
    private $value;

    /**
     * Get value.
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Set value.
     */
    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}

<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Model;

/**
 * Meta Model.
 */
class Meta
{
    /** @var int */
    private $totalCount;

    /** @var int */
    private $limit;

    /** @var int */
    private $offset;

    /**
     * Get offset.
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * Get limit.
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Get totalCount.
     */
    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    /**
     * Set totalCount.
     */
    public function setTotalCount(int $totalCount): self
    {
        $this->totalCount = $totalCount;

        return $this;
    }

    /**
     * Set limit.
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Set offset.
     */
    public function setOffset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }
}

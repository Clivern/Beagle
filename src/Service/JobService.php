<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Service;

use App\Repository\JobRepository;

/**
 * Job Service.
 */
class JobService
{
    /** @var JobRepository */
    private $jobRepository;

    /**
     * Class Constructor.
     */
    public function __construct(
        JobRepository $jobRepository
    ) {
        $this->jobRepository = $jobRepository;
    }
}

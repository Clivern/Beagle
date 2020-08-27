<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 * Job Repository.
 */
class JobRepository extends ServiceEntityRepository
{
    /**
     * Class Constructor.
     */
    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Job::class);
        $this->logger = $logger;
    }

    /**
     * Get an Job by UUID.
     */
    public function getOneByUUID(string $uuid): ?Job
    {
        $job = $this->findOneBy([
            'uuid' => $uuid,
        ]);

        return !empty($job) ? $job : null;
    }

    /**
     * Get an Job by ID.
     */
    public function getOneByID(int $id): ?Job
    {
        $job = $this->findOneBy([
            'id' => $id,
        ]);

        return !empty($job) ? $job : null;
    }

    /**
     * Insert a New Job.
     */
    public function insertOne(array $data): int
    {
        $job = new Job();
        $job->setUUID($data['uuid'])
            ->setHandler($data['handler'])
            ->setOptions($data['options'])
            ->setArgs($data['args'])
            ->setStatus($data['status'])
            ->setResult($data['result'])
            ->setCreatedAt($data['createdAt'])
            ->setUpdatedAt($data['updatedAt']);
        $this->getEntityManager()->persist($job);
        $this->getEntityManager()->flush();

        return $job->getId();
    }

    /**
     * Update an Job by ID.
     */
    public function updateOneById(int $id, array $data): bool
    {
        $job = $this->findOneBy([
            'id' => $id,
        ]);

        if (!empty($job)) {
            $job->setStatus($data['status']);
            $job->setResult($data['result']);
            $job->setRunAt($data['runAt']);
            $job->setUpdatedAt($data['updatedAt']);
            $this->getEntityManager()->flush();

            return true;
        }

        return false;
    }
}

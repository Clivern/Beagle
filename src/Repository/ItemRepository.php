<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Repository;

use App\Entity\Item;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 * Item Repository.
 */
class ItemRepository extends ServiceEntityRepository
{
    /**
     * Class Constructor.
     */
    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Item::class);
        $this->logger = $logger;
    }

    /**
     * Get an Item by ID.
     */
    public function getOneById(int $id): ?Item
    {
        $item = $this->findOneBy([
            'id' => $id,
        ]);

        return !empty($item) ? $item : null;
    }

    /**
     * Get Many Items.
     *
     * @param bool $deleted
     */
    public function getMany(int $offset, int $limit, $deleted = false): array
    {
        return [];
    }

    /**
     * Insert a New Item.
     */
    public function insertOne(array $data): int
    {
        $item = new Item();
        $item->setValue($data['value']);
        $this->getEntityManager()->persist($item);
        $this->getEntityManager()->flush();

        return $item->getId();
    }

    /**
     * Update an Item by ID.
     */
    public function updateOneById(int $id, array $data): bool
    {
        $item = $this->findOneBy([
            'id' => $id,
        ]);

        if (!empty($item)) {
            $item->setValue($data['value']);
            $this->getEntityManager()->flush();

            return true;
        }

        return false;
    }

    /**
     * Delete an Item By ID.
     *
     * @param bool $soft
     */
    public function deleteOneById(int $id, $soft = true): bool
    {
        $item = $this->getOneById($id);

        if (!empty($item) && $soft) {
            $item->setDeletedAt(new DateTime());
            $this->getEntityManager()->flush();

            return true;
        }

        if (!empty($item) && !$soft) {
            $this->getEntityManager()->remove($item);
            $this->getEntityManager()->flush();

            return true;
        }

        return false;
    }
}

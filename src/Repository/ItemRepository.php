<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Repository;

use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
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
        $this->logger = $logger;
        parent::__construct($registry, Item::class);
    }

    /**
     * Get an Item by ID.
     *
     * @return bool|Item
     */
    public function getOneById(int $id): ?Item
    {
        $item = $this->findOneBy([
            'id' => $id,
        ]);

        return !empty($item) ? $item : false;
    }

    /**
     * Get Many Items.
     *
     * @param bool $deleted
     */
    public function getMany(int $offset, int $limit, $deleted = false): array
    {
    }

    /**
     * Insert a New Item.
     */
    public function insertOne(array $data): int
    {
        $item = new Item();
        $item->setValue($data['value']);
        $this->persist($item);
        $this->flush();

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
            $this->flush();

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
            $this->flush();

            return true;
        }

        if (!empty($item) && !$soft) {
            $this->remove($item);
            $this->flush();

            return true;
        }

        return false;
    }
}

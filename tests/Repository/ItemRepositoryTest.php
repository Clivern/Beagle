<?php

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Tests\Repository;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * ItemRepositoryTest.
 */
class ItemRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /** @var ItemRepository */
    private $itemRepository;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->itemRepository = $this->entityManager
            ->getRepository(Item::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    /**
     * Test Class Name.
     *
     * @return void
     */
    public function testClass()
    {
        $this->assertTrue($this->itemRepository instanceof ItemRepository);
    }

    /**
     * Test CRUD.
     */
    public function testCrud()
    {
        $itemId = $this->itemRepository->insertOne(['value' => '~value~']);
        $item = $this->itemRepository->getOneById($itemId);

        $this->assertSame($itemId, 1);
        $this->assertSame($item->getId(), 1);
        $this->assertSame($item->getValue(), '~value~');

        $this->assertTrue(!empty($item->getCreatedAt()));
        $this->assertTrue(!empty($item->getUpdatedAt()));
        $this->assertTrue(empty($item->getDeletedAt()));

        $this->assertTrue($item->getCreatedAt() instanceof \DateTime);
        $this->assertTrue($item->getUpdatedAt() instanceof \DateTime);

        $this->assertTrue($this->itemRepository->updateOneById($itemId, ['value' => '--value--']));
        $this->assertFalse($this->itemRepository->updateOneById(20, ['value' => '--value--']));

        $item = $this->itemRepository->getOneById($itemId);
        $this->assertSame($item->getValue(), '--value--');

        $this->assertTrue($this->itemRepository->deleteOneById($itemId));

        $item = $this->itemRepository->getOneById($itemId);

        $this->assertTrue(!empty($item->getCreatedAt()));
        $this->assertTrue(!empty($item->getUpdatedAt()));
        $this->assertTrue(!empty($item->getDeletedAt()));

        $this->assertTrue($item->getCreatedAt() instanceof \DateTime);
        $this->assertTrue($item->getUpdatedAt() instanceof \DateTime);
        $this->assertTrue($item->getDeletedAt() instanceof \DateTime);

        $this->assertTrue($this->itemRepository->deleteOneById($itemId, false));

        $this->assertTrue(empty($this->itemRepository->getOneById($itemId)));
    }
}

<?php

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Tests\Repository;

use App\Entity\Option;
use App\Repository\OptionRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * OptionRepositoryTest.
 */
class OptionRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
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
        $optionRepository = $this->entityManager
            ->getRepository(Option::class)
        ;

        $this->assertTrue($optionRepository instanceof OptionRepository);
    }
}

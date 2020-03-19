<?php

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class WebTest extends WebTestCase
{
    public function getContainer()
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();

        return self::$container;
    }
}

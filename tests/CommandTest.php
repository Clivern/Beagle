<?php

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Tests;

use Symfony\Component\Console\Tester\CommandTester;

abstract class CommandTest extends CommandTester
{
    public function getContainer()
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();

        return self::$container;
    }
}

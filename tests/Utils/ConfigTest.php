<?php

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Tests\Utils;

use App\Utils\Config;
use PHPUnit\Framework\TestCase;

/**
 * ConfigTest Class.
 */
class ConfigTest extends TestCase
{
    public function testGet()
    {
        $this->assertSame((new Config())->get('APP_enV', null), 'test');
        $this->assertSame((new Config())->get('app_env', null), 'test');
        $this->assertSame((new Config())->get('not_Found', '~~not-found~~'), '~~not-found~~');
    }
}

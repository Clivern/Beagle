<?php

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Tests\Utils;

use App\Model\Meta;
use App\Utils\Serializer;
use PHPUnit\Framework\TestCase;

/**
 * SerializerTest Class.
 */
class SerializerTest extends TestCase
{
    public function testSerialize()
    {
        $metaObj = (new Meta())->setTotalCount(100)->setLimit(10)->setOffset(0);

        $this->assertSame(
            (new Serializer())->serialize($metaObj, 'json'),
            '{"offset":0,"limit":10,"totalCount":100}'
        );
    }

    public function testDeserialize()
    {
        $metaObj = (new Meta())->setTotalCount(100)->setLimit(10)->setOffset(0);

        $this->assertEquals(
            (new Serializer())->deserialize('{"offset":0,"limit":10,"totalCount":100}', Meta::class, 'json'),
            $metaObj
        );
    }
}

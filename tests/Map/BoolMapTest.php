<?php

namespace Sitnikovik\Test\Map;

use Sitnikovik\FlexArray\Map\BoolMap;
use PHPUnit\Framework\TestCase;

/**
 * Test for BoolMap
 */
class BoolMapTest extends TestCase
{

    /**
     * Test get method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map\BoolMap::get
     */
    public function testGet(): void
    {
        $map = new BoolMap();
        $map->set('key', true);

        $value = $map->get('key');
        $this->assertIsBool($value);
        $this->assertTrue($value);
    }

    /**
     * Test set method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map\BoolMap::set
     */
    public function testSet(): void
    {
        $map = new BoolMap();
        $map->set('key', true);

        $value = $map->get('key');
        $this->assertIsBool($value);
        $this->assertTrue($value);
    }
}

<?php

namespace Sitnikovik\Test\Map;

use Sitnikovik\FlexArray\Map\IntMap;
use PHPUnit\Framework\TestCase;

/**
 * Test for IntMap
 */
class IntMapTest extends TestCase
{
    /**
     * Test set method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map\IntMap::set
     */
    public function testSet(): void
    {
        $map = new IntMap();
        $map->set('key', 1);

        $value = $map->get('key');
        $this->assertIsInt($value);
        $this->assertEquals(1, $value);
    }

    /**
     * Test get method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map\IntMap::get
     */
    public function testGet(): void
    {
        $map = new IntMap();
        $map->set('key', 1);

        $value = $map->get('key');
        $this->assertIsInt($value);
        $this->assertEquals(1, $value);
    }
}

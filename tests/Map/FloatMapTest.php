<?php

namespace Sitnikovik\Test\Map;

use Sitnikovik\FlexArray\Map\FloatMap;
use PHPUnit\Framework\TestCase;

/**
 * Test for FloatMap
 */
class FloatMapTest extends TestCase
{
    /**
     * Test get method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map\FloatMap::get
     */
    public function testGet(): void
    {
        $map = new FloatMap();
        $map->set('key', 1.1);

        $value = $map->get('key');
        $this->assertIsFloat($value);
        $this->assertEquals(1.1, $value);
    }

    /**
     * Test set method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map\FloatMap::set
     */
    public function testSet(): void
    {
        $map = new FloatMap();
        $map->set('key', 1.1);

        $value = $map->get('key');
        $this->assertIsFloat($value);
        $this->assertEquals(1.1, $value);
    }
}

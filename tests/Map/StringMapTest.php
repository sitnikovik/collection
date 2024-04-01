<?php

namespace Sitnikovik\Test\Map;

use Sitnikovik\FlexArray\Map\StringMap;
use PHPUnit\Framework\TestCase;

/**
 * Test for StringMap
 */
class StringMapTest extends TestCase
{
    /**
     * Test set method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map\StringMap::set
     */
    public function testSet(): void
    {
        $map = new StringMap();
        $map->set('key', 'value');

        $value = $map->get('key');
        $this->assertIsString($value);
        $this->assertEquals('value', $value);
    }

    /**
     * Test get method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map\StringMap::get
     */
    public function testGet(): void
    {
        $map = new StringMap();
        $map->set('key', 'value');

        $value = $map->get('key');
        $this->assertIsString($value);
        $this->assertEquals('value', $value);
    }
}

<?php

namespace Sitnikovik\Test;

use PHPUnit\Framework\TestCase;
use Sitnikovik\FlexArray\Map;

/**
 * Class MapTest
 */
class MapTest extends TestCase
{
    /**
     * Tests count method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map::count
     */
    public function testCount(): void
    {
        $map = new Map();
        $this->assertEquals(0, $map->count());

        $map->set('key', 'value');
        $this->assertEquals(1, $map->count());

        $map->set('key2', 'value2');
        $this->assertEquals(2, $map->count());
    }

    /**
     * Tests isNotEmpty method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map::isNotEmpty
     */
    public function testIsNotEmpty(): void
    {
        $map = new Map();
        $this->assertFalse($map->isNotEmpty());

        $map->set('key', 'value');
        $this->assertTrue($map->isNotEmpty());
    }

    /**
     * Tests get method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map::get
     */
    public function testGet(): void
    {
        $map = new Map();

        $map->set('key', 'value');
        $this->assertEquals('value', $map->get('key'));

        $map->set('key', 'value2');
        $this->assertEquals('value2', $map->get('key'));
    }

    /**
     * Tests has method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map::has
     */
    public function testHas(): void
    {
        $map = new Map();

        $map->set('key', 'value');
        $this->assertTrue($map->has('key'));

        $map->remove('key');
        $this->assertFalse($map->has('key'));
    }

    /**
     * Tests clear method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map::clear
     */
    public function testClear(): void
    {
        $map = new Map();

        $map->set('key', 'value');
        $map->set('key2', 'value2');
        $map->clear();

        $this->assertEquals(0, $map->count());
    }

    /**
     * Tests remove method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map::remove
     */
    public function testRemove(): void
    {
        $map = new Map();

        $map->set('key', 'value');
        $map->remove('key');

        $this->assertFalse($map->has('key'));
    }

    /**
     * Tests isEmpty method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map::isEmpty
     */
    public function testIsEmpty(): void
    {
        $map = new Map();

        $this->assertTrue($map->isEmpty());

        $map->set('key', 'value');
        $this->assertFalse($map->isEmpty());
    }

    /**
     * Tests values method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map::values
     */
    public function testValues(): void
    {
        $map = new Map();

        $map->set('key', 'value');
        $map->set('key2', 'value2');

        $this->assertEquals(['value', 'value2'], $map->values());
    }

    /**
     * Tests set method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map::set
     */
    public function testSet(): void
    {
        $map = new Map();

        $map->set('key', 'value');
        $this->assertEquals('value', $map->get('key'));
    }

    /**
     * Tests keys method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map::keys
     */
    public function testKeys(): void
    {
        $map = new Map();

        $map->set('key', 'value');
        $map->set('key2', 'value2');

        $this->assertEquals(['key', 'key2'], $map->keys());
    }

    /**
     * Tests all method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\Map::all
     */
    public function testAll(): void
    {
        $map = new Map();

        $map->set('key', 'value');
        $map->set('key2', 'value2');

        $this->assertEquals(['key' => 'value', 'key2' => 'value2'], $map->all());
    }
}

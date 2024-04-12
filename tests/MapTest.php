<?php

namespace Sitnikovik\Test;

use PHPUnit\Framework\TestCase;
use Sitnikovik\FlexArray\MixedMap;

/**
 * Class MapTest
 */
class MapTest extends TestCase
{
    /**
     * Tests count method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\MixedMap::count
     */
    public function testCount(): void
    {
        $map = new MixedMap();
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
     * @covers \Sitnikovik\FlexArray\MixedMap::isNotEmpty
     */
    public function testIsNotEmpty(): void
    {
        $map = new MixedMap();
        $this->assertFalse($map->isNotEmpty());

        $map->set('key', 'value');
        $this->assertTrue($map->isNotEmpty());
    }

    /**
     * Tests get method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\MixedMap::get
     */
    public function testGet(): void
    {
        $map = new MixedMap();

        $map->set('key', 'value');
        $this->assertEquals('value', $map->get('key'));

        $map->set('key', 'value2');
        $this->assertEquals('value2', $map->get('key'));
    }

    /**
     * Tests has method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\MixedMap::has
     */
    public function testHas(): void
    {
        $map = new MixedMap();

        $map->set('key', 'value');
        $this->assertTrue($map->has('key'));

        $map->remove('key');
        $this->assertFalse($map->has('key'));
    }

    /**
     * Tests clear method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\MixedMap::clear
     */
    public function testClear(): void
    {
        $map = new MixedMap();

        $map->set('key', 'value');
        $map->set('key2', 'value2');
        $map->clear();

        $this->assertEquals(0, $map->count());
    }

    /**
     * Tests remove method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\MixedMap::remove
     */
    public function testRemove(): void
    {
        $map = new MixedMap();

        $map->set('key', 'value');
        $map->remove('key');

        $this->assertFalse($map->has('key'));
    }

    /**
     * Tests isEmpty method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\MixedMap::isEmpty
     */
    public function testIsEmpty(): void
    {
        $map = new MixedMap();

        $this->assertTrue($map->isEmpty());

        $map->set('key', 'value');
        $this->assertFalse($map->isEmpty());
    }

    /**
     * Tests values method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\MixedMap::values
     */
    public function testValues(): void
    {
        $map = new MixedMap();

        $map->set('key', 'value');
        $map->set('key2', 'value2');

        $this->assertEquals(['value', 'value2'], $map->values());
    }

    /**
     * Tests set method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\MixedMap::set
     */
    public function testSet(): void
    {
        $map = new MixedMap();

        $map->set('key', 'value');
        $this->assertEquals('value', $map->get('key'));
    }

    /**
     * Tests keys method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\MixedMap::keys
     */
    public function testKeys(): void
    {
        $map = new MixedMap();

        $map->set('key', 'value');
        $map->set('key2', 'value2');

        $this->assertEquals(['key', 'key2'], $map->keys());
    }

    /**
     * Tests all method
     *
     * @return void
     * @covers \Sitnikovik\FlexArray\MixedMap::pairs
     */
    public function testPairs(): void
    {
        $map = new MixedMap();

        $map->set('key', 'value');
        $map->set('key2', 'value2');

        $this->assertEquals(['key' => 'value', 'key2' => 'value2'], $map->pairs());
    }
}

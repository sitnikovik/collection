<?php

namespace Sitnikovik\Test\TypeList;

use PHPUnit\Framework\TestCase;
use Sitnikovik\FlexArray\Tuple\MixedTuple;

/**
 * Test for MixedTuple
 * 
 * @covers Sitnikovik\FlexArray\Tuple\MixedTuple
 */
class MixedTupleTest extends TestCase
{
        /**
     * Tests the constructor not throws an exception on invalid data
     * 
     * @return void
     * @covers  Sitnikovik\FlexArray\Tuple\IntTuple::__construct
     */
    public function testConstuctNotThrowsException()
    {
        new MixedTuple(["1", 2, 3]);
        
        $this->assertTrue(true);
    }

    /**
     * Tests the get method
     * 
     * @return void
     * @covers Sitnikovik\FlexArray\Tuple\MixedTuple::get
     */
    public function testGetReturnsExpected(): void
    {
        $data = ['apple', 123, true];
        $tuple = new MixedTuple($data);

        foreach ($data as $index => $value) {
            $this->assertEquals($value, $tuple->get($index));
        }
        $this->assertNull($tuple->get(count($data)));
    }

    /**
     * Tests the all method that returns all values
     * 
     * @return void
     * @covers Sitnikovik\FlexArray\Tuple\MixedTuple::all
     */
    public function testAllReturnsExpected(): void
    {
        $data = ['apple', 123, true];
        $tuple = new MixedTuple($data);

        $this->assertEquals($data, $tuple->all());
    }

    /**
     * Tests the count method
     * 
     * @return void
     * @covers Sitnikovik\FlexArray\Tuple\MixedTuple::count
     */
    public function testCount(): void
    {
        $data = ['apple', 123, true];
        $tuple = new MixedTuple($data);

        $this->assertEquals(count($data), $tuple->count());
    }
}
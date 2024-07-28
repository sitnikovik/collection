<?php

namespace Sitnikovik\Test\TypeList;

use PHPUnit\Framework\TestCase;
use Sitnikovik\FlexArray\Tuple\FloatTuple;

/**
 * Test for FloatTuple
 * 
 * @covers Sitnikovik\FlexArray\Tuple\FloatTuple
 */
class FloatTupleTest extends TestCase
{
    /**
     * Tests the constructor throws an exception on invalid data
     * 
     * @return void
     * @covers  Sitnikovik\FlexArray\Tuple\FloatTuple::__construct
     */
    public function testConstuctThrowsExceptionOnInvalidData(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid value at index 1');

        new FloatTuple([1.2, 2, 3]);
    }

    /**
     * Tests the get method
     * 
     * @return void
     * @covers Sitnikovik\FlexArray\Tuple\FloatTuple::get
     */
    public function testGetReturnsExpected(): void
    {
        $data = [1.0, 2.4, 4.6];
        $tuple = new FloatTuple($data);

        foreach ($data as $index => $value) {
            $this->assertEquals($value, $tuple->get($index));
        }
        $this->assertNull($tuple->get(count($data)));
    }

    /**
     * Tests the all method that returns all values
     * 
     * @return void
     * @covers Sitnikovik\FlexArray\Tuple\FloatTuple::all
     */
    public function testAllReturnsExpected(): void
    {
        $data = [1.0, 2.4, 4.6];
        $tuple = new FloatTuple($data);

        $this->assertEquals($data, $tuple->all());
    }
}
<?php

namespace Sitnikovik\Test\TypeList;

use PHPUnit\Framework\TestCase;
use Sitnikovik\FlexArray\Tuple\IntTuple;

/**
 * Test for IntTuple
 * 
 * @covers Sitnikovik\FlexArray\Tuple\IntTuple
 */
class IntTupleTest extends TestCase
{
    /**
     * Tests the constructor throws an exception on invalid data
     * 
     * @return void
     * @covers  Sitnikovik\FlexArray\Tuple\IntTuple::__construct
     */
    public function testConstuctThrowsExceptionOnInvalidData(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid value at index 0');

        new IntTuple(["1", 2, 3]);
    }

    /**
     * Tests the get method
     * 
     * @return void
     * @covers Sitnikovik\FlexArray\Tuple\IntTuple::get
     */
    public function testGetReturnsExpected(): void
    {
        $data = [1, 2, 3];
        $tuple = new IntTuple($data);

        foreach ($data as $index => $value) {
            $this->assertEquals($value, $tuple->get($index));
        }
        $this->assertNull($tuple->get(count($data)));
    }

    /**
     * Tests the all method that returns all values
     * 
     * @return void
     * @covers Sitnikovik\FlexArray\Tuple\IntTuple::all
     */
    public function testAllReturnsExpected(): void
    {
        $data = [1, 2, 3];
        $tuple = new IntTuple($data);

        $this->assertEquals($data, $tuple->all());
    }
}
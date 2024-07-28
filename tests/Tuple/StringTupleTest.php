<?php

namespace Sitnikovik\Test\TypeList;

use PHPUnit\Framework\TestCase;
use Sitnikovik\FlexArray\Tuple\StringTuple;

/**
 * Test for StringTuple
 * 
 * @covers Sitnikovik\FlexArray\Tuple\StringTuple
 */
class StringTupleTest extends TestCase
{
    /**
     * Tests the constructor throws an exception on invalid data
     * 
     * @return void
     * @covers  Sitnikovik\FlexArray\Tuple\StringTuple::__construct
     */
    public function testConstuctThrowsExceptionOnInvalidData(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid value at index 1');

        new StringTuple(['1', 2, '3']);
    }

    /**
     * Tests the get method
     * 
     * @return void
     * @covers Sitnikovik\FlexArray\Tuple\StringTuple::get
     */
    public function testGetReturnsExpected(): void
    {
        $data = ['foo', 'bar'];
        $tuple = new StringTuple($data);

        foreach ($data as $index => $value) {
            $this->assertEquals($value, $tuple->get($index));
        }
        $this->assertNull($tuple->get(count($data)));
    }

    /**
     * Tests the all method that returns all values
     * 
     * @return void
     * @covers Sitnikovik\FlexArray\Tuple\StringTuple::all
     */
    public function testAllReturnsExpected(): void
    {
        $data = ['foo', 'bar'];
        $tuple = new StringTuple($data);

        $this->assertEquals($data, $tuple->all());
    }
}
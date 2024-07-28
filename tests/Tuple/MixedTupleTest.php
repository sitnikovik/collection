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
     * Tests the get method
     */
    public function testGet()
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
     */
    public function testAll()
    {
        $data = ['apple', 123, true];
        $tuple = new MixedTuple($data);

        $this->assertEquals($data, $tuple->all());
    }
}
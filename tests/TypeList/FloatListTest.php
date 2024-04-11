<?php

namespace Sitnikovik\Test\TypeList;

use InvalidArgumentException;
use OutOfBoundsException;
use OverflowException;
use Sitnikovik\FlexArray\TypeList\FloatList;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the FloatList class
 */
class FloatListTest extends TestCase
{
    /**
     * Tests if the __construct method throws an exception on providing invalid data
     *
     * @return void
     * @covers ::__construct
     */
    public function test__constructThrowsExceptionOnInvalidData(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Array type is invalid');

        new FloatList([1, 1.0]);
    }

    /**
     * Tests if the __construct method throws an exception on providing invalid data
     *
     * @return void
     * @covers ::__construct
     */
    public function test__constructThrowsExceptionOnDataOutOfCapacity(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Capacity is less than the array size');

        new FloatList([1.0, 2.5], 1);
    }

    /**
     * Tests if the append method appends a string to the array
     *
     * @return void
     * @covers ::append
     */
    public function testAppend(): void
    {
        $floatList = new FloatList();

        $this->assertEquals(0, $floatList->length());

        $floatList->append(10.1);

        $this->assertEquals(1, $floatList->length());
        $this->assertEquals(10.1, $floatList->get(0));
    }

    /**
     * Tests if the append method throws an exception on full
     *
     * @return void
     * @covers ::append
     */
    public function testAppendThrowsExceptionOnFull(): void
    {
        $this->expectException(OverflowException::class);
        $this->expectExceptionMessage('Array is full of data');

        $floatList = new FloatList([
            1.0,
            2.5,
            3.2,
        ], 3);

        $floatList->append(2.8);
    }

    /**
     * Tests if the get method returns the value at the given index
     *
     * @return void
     * @covers ::get
     */
    public function testGet(): void
    {
        $floatList = new FloatList([1.0, 2.0, 2.5]);

        $this->assertEquals(1.0, $floatList->get(0));
        $this->assertEquals(2.5, $floatList->get(2));
    }

    /**
     * Tests if the get method throws an exception on index out of bounds
     *
     * @return void
     * @covers ::get
     */
    public function testGetThrowsExceptionOnIndexOutOfBounds(): void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Index "3" out of bounds');

        $floatList = new FloatList([1.5, 2.0, 2.5]);

        $floatList->get(3);
    }

    /**
     * Tests if the get method not throws an exception on no existing index
     *
     * @return void
     * @covers ::get
     */
    public function testGetNotThrowsExceptionOnArrayIndexDoesNotExist(): void
    {
        $floatList = new FloatList([
            0 => 1.0,
            2 => 1.7,
        ]);

        $this->assertEquals(1.7, $floatList->get(1));
    }

    /**
     * Tests if the remove method removes the value at the given index
     *
     * @return void
     * @covers ::remove
     */
    public function testRemove(): void
    {
        $floatList = new FloatList([1.6, 2.5, 2.8]);

        $floatList->remove(1);

        $this->assertEquals(2, $floatList->length());
        $this->assertEquals(1.6, $floatList->get(0));
        $this->assertEquals(2.8, $floatList->get(1));
    }

    /**
     * Tests if the remove method throws an exception on index out of bounds
     *
     * @return void
     * @covers ::remove
     */
    public function testRemoveThrowsExceptionOnIndexOutOfBounds(): void
    {
        $this->expectException(OverflowException::class);
        $this->expectExceptionMessage('Index "3" out of bounds');

        $floatList = new FloatList([1.5, 2.0, 2.8]);

        $floatList->remove(3);
    }

    /**
     * Tests if the remove method not throws an exception on no existing index
     *
     * @return void
     * @covers ::remove
     */
    public function testRemoveNotThrowsExceptionOnArrayIndexDoesNotExist(): void
    {
        $floatList = new FloatList([
            0 => 1.6,
            2 => 2.8,
        ]);

        $floatList->remove(1);

        $this->assertEquals(1, $floatList->length());
        $this->assertEquals(1.6, $floatList->get(0));
    }

    /**
     * Tests if the replace method replaces the value at the given index
     *
     * @return void
     * @covers ::replace
     */
    public function testReplace(): void
    {
        $floatList = new FloatList([1.6, 2.8, 2.9]);

        $floatList->replace(1, 1.8);

        $this->assertEquals(3, $floatList->length());
        $this->assertEquals(1.6, $floatList->get(0));
        $this->assertEquals(1.8, $floatList->get(1));
        $this->assertEquals(2.9, $floatList->get(2));
    }

    /**
     * Tests if the replace method throws an exception on index out of bounds
     *
     * @return void
     * @covers ::replace
     */
    public function testReplaceThrowsExceptionOnIndexOutOfBounds(): void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Index "3" out of bounds');

        $floatList = new FloatList([1.6, 2.5, 3.0]);

        $floatList->replace(3, 4.4);
    }

    /**
     * Tests if the indexOf method returns the index of the given value
     *
     * @return void
     * @covers ::indexOf
     */
    public function testIndexOfReturnsIndexOfValue(): void
    {
        $floatList = new FloatList([1.4, 2.5, 2.55, -1.4]);

        $this->assertEquals(2, $floatList->indexOf(2.55));
        $this->assertEquals(3, $floatList->indexOf(-1.4));
    }

    /**
     * Tests if the indexOf method returns null if the value is not found
     *
     * @return void
     * @covers ::indexOf
     */
    public function testIndexOfReturnsNullIfValueNotFound(): void
    {
        $floatList = new FloatList([1.5, 0.9, 2.4]);

        $this->assertNull($floatList->indexOf(-1));
    }

    /**
     * Tests if the indexesOf method returns the indexes of the given values
     *
     * @return void
     * @covers ::indexesOf
     */
    public function testIndexesOfReturnsExpected(): void
    {
        $floatList = new FloatList([
            1.5,
            0.0,
            2.2,
            0.0,
            -1.5,
            -2.5,
        ]);

        $this->assertEquals([1, 3], $floatList->indexesOf(0.0, 0.0));
        $this->assertEquals([4, 5], $floatList->indexesOf(-1.5, -2.5));
    }

    /**
     * Tests if the has method returns true if the value is found
     *
     * @return void
     * @covers ::has
     */
    public function testHasReturnsExpected(): void
    {
        $floatList = new FloatList([
            1.5,
            0.0,
            2.2,
            0.0,
            -1.5,
            -2.5,
        ]);

        $this->assertTrue($floatList->has(0.0));
        $this->assertFalse($floatList->has(-3.0));
    }

    /**
     * Tests if the hasAny method returns true if any of the values is found
     *
     * @return void
     * @covers ::hasAny
     */
    public function testHasAnyReturnsExpected(): void
    {
        $floatList = new FloatList([
            1.5,
            0.0,
            2.2,
            0.0,
            -1.5,
            -2.5,
        ]);

        $this->assertTrue($floatList->hasAny(1.5, -3.0));
        $this->assertFalse($floatList->hasAny(-3.0, 2.55));
    }

    /**
     * Tests if the hasAll method returns true if all values found
     *
     * @return void
     * @covers ::hasAny
     */
    public function testHasAllReturnsExpected(): void
    {
        $floatList = new FloatList([
            1.5,
            0.0,
            2.2,
            0.0,
            -1.5,
            -2.5,
        ]);

        $this->assertTrue($floatList->hasAll(0.0, 0.0, 1.5));
        $this->assertFalse($floatList->hasAll(0.0, 0.0, 3.0));
    }

    /**
     * Tests if the all method returns the array
     *
     * @return void
     * @covers ::values
     */
    public function testAll(): void
    {
        $expected = [
            1.5,
            0.0,
            2.2,
            0.0,
            -1.5,
            -2.5,
        ];
        $floatList = new FloatList($expected);

        $expected[] = 3.5;
        $floatList->append(3.5);

        $this->assertEquals($expected, $floatList->values());
    }

    /**
     * Tests if the isFull method returns true if the array is full
     *
     * @return void
     * @covers ::isFull
     */
    public function testIsFullReturnsTrue(): void
    {
        $floatList = new FloatList([1.0, 0.6, 2.6], 3);

        $this->assertTrue($floatList->isFull());
    }

    /**
     * Tests if the isFull method returns false if the array is not full
     *
     * @return void
     * @covers ::isFull
     */
    public function testIsFullReturnsFalse(): void
    {
        $floatList = new FloatList([1.9, 2.5], 3);

        $this->assertFalse($floatList->isFull());
    }

    /**
     * Tests if the left method returns the capacity left
     *
     * @return void
     * @covers ::left
     */
    public function testLeft(): void
    {
        $floatList = new FloatList([1.5, 2.6], 3);

        $this->assertEquals(1, $floatList->left());
    }

    /**
     * Tests if the length method returns the length of the array
     *
     * @return void
     * @covers ::length
     */
    public function testLength(): void
    {
        $floatList = new FloatList([1.7, 2.77]);

        $this->assertEquals(2, $floatList->length());
    }

    /**
     * Tests if the increaseCapacity method increases the capacity of the array
     *
     * @return void
     * @covers ::increaseCapacity
     */
    public function testIncreaseCapacity(): void
    {
        $floatList = new FloatList([1.3, 2.5]);

        $floatList
            ->append(3.66)
            ->append(4.23)
            ->append(5.55)
        ;
        $this->assertEquals(3, $floatList->left());

        $floatList->append(6.79);
        $this->assertEquals(2, $floatList->left());

        $floatList
            ->append(7.6)
            ->append(8.7)
            ->append(9.3)
        ;
        $this->assertEquals(7, $floatList->left());
    }

    /**
     * Tests if the capacity method returns the capacity of the array
     *
     * @return void
     * @covers ::capacity
     */
    public function testCapacity(): void
    {
        $floatList = new FloatList([1.6, 2.5], 3);

        $this->assertEquals(3, $floatList->capacity());

        $floatList->append(3.6);
        $this->assertEquals(3, $floatList->capacity());
    }

    /**
     * Tests if the sum method returns the sum of all the values in the array
     *
     * @return void
     * @covers ::sum
     */
    public function testSum(): void
    {
        $floatList = new FloatList([1.5, 2.5, 3.55]);

        $this->assertEquals(7.55, $floatList->sum());
    }

    /**
     * Tests if the unique method makes the array with unique values
     *
     * @return void
     * @covers ::unique
     */
    public function testUnique(): void
    {
        $floatList = new FloatList([1.5, 2.5, 2.5, 3.5]);

        $this->assertEquals([1.5, 2.5, 3.5], $floatList->unique()->values());
    }

    /**
     * Tests if the filter method filters the array by callback
     *
     * @return void
     * @covers ::unique
     */
    public function testFilter(): void
    {
        $floatList = new FloatList([1.5, 2.5, 3.5, 4.5]);

        $floatList->filter(static function($value) {
            return $value > 2.0;
        });

        $this->assertEquals([2.5, 3.5, 4.5], $floatList->values());
    }

    /**
     * Tests if the sort method sorts the array by callback
     *
     * @return void
     * @covers ::sort
     */
    public function testSort(): void
    {
        $floatList = new FloatList([3.5, 1.5, 2.5, 4.5]);

        $floatList->sort();

        $this->assertEquals([1.5, 2.5, 3.5, 4.5], $floatList->values());
    }
}

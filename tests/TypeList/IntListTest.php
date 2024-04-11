<?php

namespace Sitnikovik\Test\TypeList;

use InvalidArgumentException;
use OutOfBoundsException;
use OverflowException;
use Sitnikovik\FlexArray\TypeList\IntList;
use PHPUnit\Framework\TestCase;

/**
 * Test class for IntList
 */
class IntListTest extends TestCase
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

        new IntList([1, 1.0]);
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

        new IntList([0, 1], 1);
    }

    /**
     * Tests if the append method appends a string to the array
     *
     * @return void
     * @covers ::append
     */
    public function testAppend(): void
    {
        $intList = new IntList();

        $this->assertEquals(0, $intList->length());

        $intList->append(101);

        $this->assertEquals(1, $intList->length());
        $this->assertEquals(101, $intList->get(0));
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

        $intList = new IntList([
            1,
            0,
            1,
        ], 3);

        $intList->append(2);
    }

    /**
     * Tests if the get method returns the value at the given index
     *
     * @return void
     * @covers ::get
     */
    public function testGet(): void
    {
        $intList = new IntList([1, 0, 2]);

        $this->assertEquals(1, $intList->get(0));
        $this->assertEquals(2, $intList->get(2));
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

        $intList = new IntList([1, 0, 2]);

        $intList->get(3);
    }

    /**
     * Tests if the get method not throws an exception on no existing index
     *
     * @return void
     * @covers ::get
     */
    public function testGetNotThrowsExceptionOnArrayIndexDoesNotExist(): void
    {
        $intList = new IntList([
            0 => 0,
            2 => 1,
        ]);

        $this->assertEquals(1, $intList->get(1));
    }

    /**
     * Tests if the remove method removes the value at the given index
     *
     * @return void
     * @covers ::remove
     */
    public function testRemove(): void
    {
        $intList = new IntList([1, 0, 2]);

        $intList->remove(1);

        $this->assertEquals(2, $intList->length());
        $this->assertEquals(1, $intList->get(0));
        $this->assertEquals(2, $intList->get(1));
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

        $intList = new IntList([1, 0, 2]);

        $intList->remove(3);
    }

    /**
     * Tests if the remove method not throws an exception on no existing index
     *
     * @return void
     * @covers ::remove
     */
    public function testRemoveNotThrowsExceptionOnArrayIndexDoesNotExist(): void
    {
        $intList = new IntList([
            0 => 1,
            2 => 2,
        ]);

        $intList->remove(1);

        $this->assertEquals(1, $intList->length());
        $this->assertEquals(1, $intList->get(0));
    }

    /**
     * Tests if the replace method replaces the value at the given index
     *
     * @return void
     * @covers ::replace
     */
    public function testReplace(): void
    {
        $intList = new IntList([1, 0, 2]);

        $intList->replace(1, 1);

        $this->assertEquals(3, $intList->length());
        $this->assertEquals(1, $intList->get(0));
        $this->assertEquals(1, $intList->get(1));
        $this->assertEquals(2, $intList->get(2));
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

        $intList = new IntList([1, 0, 2]);

        $intList->replace(3, 4);
    }

    /**
     * Tests if the indexOf method returns the index of the given value
     *
     * @return void
     * @covers ::indexOf
     */
    public function testIndexOfReturnsIndexOfValue(): void
    {
        $intList = new IntList([1, 0, 2, -1]);

        $this->assertEquals(2, $intList->indexOf(2));
        $this->assertEquals(3, $intList->indexOf(-1));
    }

    /**
     * Tests if the indexOf method returns null if the value is not found
     *
     * @return void
     * @covers ::indexOf
     */
    public function testIndexOfReturnsNullIfValueNotFound(): void
    {
        $intList = new IntList([1, 0, 2]);

        $this->assertNull($intList->indexOf(-1));
    }

    /**
     * Tests if the indexesOf method returns the indexes of the given values
     *
     * @return void
     * @covers ::indexesOf
     */
    public function testIndexesOfReturnsExpected(): void
    {
        $intList = new IntList([1, 0, 2, 0, -1, -2]);

        $this->assertEquals([1, 3], $intList->indexesOf(0, 0));
        $this->assertEquals([4, 5], $intList->indexesOf(-1, -2));
    }

    /**
     * Tests if the has method returns true if the value is found
     *
     * @return void
     * @covers ::has
     */
    public function testHasReturnsExpected(): void
    {
        $intList = new IntList([1, 0, 2, 0, -1, -2]);

        $this->assertTrue($intList->has(0));
        $this->assertFalse($intList->has(-3));
    }

    /**
     * Tests if the hasAny method returns true if any of the values is found
     *
     * @return void
     * @covers ::hasAny
     */
    public function testHasAnyReturnsExpected(): void
    {
        $intList = new IntList([1, 0, 2, 0, -1, -2]);

        $this->assertTrue($intList->hasAny(1, -3));
        $this->assertFalse($intList->hasAny(-3, 3));
    }

    /**
     * Tests if the hasAll method returns true if all values found
     *
     * @return void
     * @covers ::hasAny
     */
    public function testHasAllReturnsExpected(): void
    {
        $intList = new IntList([1, 0, 2, 0, -1, -2]);

        $this->assertTrue($intList->hasAll(0, 0, 1));
        $this->assertFalse($intList->hasAll(0, 0, 3));
    }

    /**
     * Tests if the all method returns the array
     *
     * @return void
     * @covers ::values
     */
    public function testAll(): void
    {
        $expected = [1, 0, 2, 0, -1, -2];

        $intList = new IntList($expected);

        $expected[] = 3;
        $intList->append(3);

        $this->assertEquals($expected, $intList->values());
    }

    /**
     * Tests if the isFull method returns true if the array is full
     *
     * @return void
     * @covers ::isFull
     */
    public function testIsFullReturnsTrue(): void
    {
        $intList = new IntList([1, 0, 2], 3);

        $this->assertTrue($intList->isFull());
    }

    /**
     * Tests if the isFull method returns false if the array is not full
     *
     * @return void
     * @covers ::isFull
     */
    public function testIsFullReturnsFalse(): void
    {
        $intList = new IntList([1, 2], 3);

        $this->assertFalse($intList->isFull());
    }

    /**
     * Tests if the left method returns the capacity left
     *
     * @return void
     * @covers ::left
     */
    public function testLeft(): void
    {
        $intList = new IntList([1, 2], 3);

        $this->assertEquals(1, $intList->left());
    }

    /**
     * Tests if the length method returns the length of the array
     *
     * @return void
     * @covers ::length
     */
    public function testLength(): void
    {
        $intList = new IntList([1, 2]);

        $this->assertEquals(2, $intList->length());
    }

    /**
     * Tests if the increaseCapacity method increases the capacity of the array
     *
     * @return void
     * @covers ::increaseCapacity
     */
    public function testIncreaseCapacity(): void
    {
        $intList = new IntList([1, 2]);

        $intList
            ->append(3)
            ->append(4)
            ->append(5)
        ;
        $this->assertEquals(3, $intList->left());

        $intList->append(6);
        $this->assertEquals(2, $intList->left());

        $intList
            ->append(7)
            ->append(8)
            ->append(9)
        ;
        $this->assertEquals(7, $intList->left());
    }

    /**
     * Tests if the capacity method returns the capacity of the array
     *
     * @return void
     * @covers ::capacity
     */
    public function testCapacity(): void
    {
        $intList = new IntList([1, 2], 3);

        $this->assertEquals(3, $intList->capacity());

        $intList->append(3);
        $this->assertEquals(3, $intList->capacity());
    }

    /**
     * Tests if the sum method returns the sum of all the values in the array
     *
     * @return void
     * @covers ::sum
     */
    public function testSum(): void
    {
        $intList = new IntList([1, 2, 3]);

        $this->assertEquals(6, $intList->sum());

        $intList->append(4);
        $this->assertEquals(10, $intList->sum());
    }

    /**
     * Tests if the unique method makes the array with unique values
     *
     * @return void
     * @covers ::unique
     */
    public function testUnique(): void
    {
        $floatList = new IntList([1, 2, 2, 3]);

        $this->assertEquals([1, 2, 3], $floatList->unique()->values());
    }

    /**
     * Tests if the filter method filters the array by callback
     *
     * @return void
     * @covers ::unique
     */
    public function testFilter(): void
    {
        $floatList = new IntList([1, 2, 3, 4]);

        $floatList->filter(static function($value) {
            return $value > 2;
        });

        $this->assertEquals([3, 4], $floatList->values());
    }

    /**
     * Tests if the sort method sorts the array by callback
     *
     * @return void
     * @covers ::sort
     */
    public function testSort(): void
    {
        $floatList = new IntList([3, 1, 2, 4]);

        $floatList->sort();

        $this->assertEquals([1, 2, 3, 4], $floatList->values());
    }
}

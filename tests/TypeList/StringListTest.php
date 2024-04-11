<?php

namespace Sitnikovik\Test\TypeList;

use InvalidArgumentException;
use OutOfBoundsException;
use OverflowException;
use Sitnikovik\FlexArray\TypeList\StringList;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the StringList class
 *
 * @coversDefaultClass \Sitnikovik\FlexArray\TypeList\StringList
 */
class StringListTest extends TestCase
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

        new StringList([1, "1"]);
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

        new StringList(["string_0", "string_1"], 1);
    }

    /**
     * Tests if the append method appends a string to the array
     *
     * @return void
     * @covers ::append
     */
    public function testAppend(): void
    {
        $stringList = new StringList();

        $this->assertEquals(0, $stringList->length());

        $stringList->append('string1');

        $this->assertEquals(1, $stringList->length());
        $this->assertEquals('string1', $stringList->get(0));
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

        $stringList = new StringList([
            "string_0",
            "string_1",
            "string_2",
        ], 3);

        $stringList->append("string_3");
    }

    /**
     * Tests if the get method returns the value at the given index
     *
     * @return void
     * @covers ::get
     */
    public function testGet(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $this->assertEquals("string_0", $stringList->get(0));
        $this->assertEquals("string_2", $stringList->get(2));
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

        $stringList = new StringList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $stringList->get(3);
    }

    /**
     * Tests if the get method not throws an exception on no existing index
     *
     * @return void
     * @covers ::get
     */
    public function testGetNotThrowsExceptionOnArrayIndexDoesNotExist(): void
    {
        $stringList = new StringList([
            0 => "string_0",
            2 => "string_2",
        ]);

        $this->assertEquals("string_2", $stringList->get(1));
    }

    /**
     * Tests if the remove method removes the value at the given index
     *
     * @return void
     * @covers ::remove
     */
    public function testRemove(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $stringList->remove(1);

        $this->assertEquals(2, $stringList->length());
        $this->assertEquals("string_0", $stringList->get(0));
        $this->assertEquals("string_2", $stringList->get(1));
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

        $stringList = new StringList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $stringList->remove(3);
    }

    /**
     * Tests if the remove method not throws an exception on no existing index
     *
     * @return void
     * @covers ::remove
     */
    public function testRemoveNotThrowsExceptionOnArrayIndexDoesNotExist(): void
    {
        $stringList = new StringList([
            0 => "string_0",
            2 => "string_2",
        ]);

        $stringList->remove(1);

        $this->assertEquals(1, $stringList->length());
        $this->assertEquals("string_0", $stringList->get(0));
    }

    /**
     * Tests if the replace method replaces the value at the given index
     *
     * @return void
     * @covers ::replace
     */
    public function testReplace(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $stringList->replace(1, "string_3");

        $this->assertEquals(3, $stringList->length());
        $this->assertEquals("string_0", $stringList->get(0));
        $this->assertEquals("string_3", $stringList->get(1));
        $this->assertEquals("string_2", $stringList->get(2));
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

        $stringList = new StringList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $stringList->replace(3, "string_3");
    }

    /**
     * Tests if the indexOf method returns the index of the given value
     *
     * @return void
     * @covers ::indexOf
     */
    public function testIndexOfReturnsIndexOfValue(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $this->assertEquals(1, $stringList->indexOf("string_1"));
        $this->assertEquals(2, $stringList->indexOf("string_2"));
    }

    /**
     * Tests if the indexOf method returns null if the value is not found
     *
     * @return void
     * @covers ::indexOf
     */
    public function testIndexOfReturnsNullIfValueNotFound(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $this->assertNull($stringList->indexOf("string_3"));
    }

    /**
     * Tests if the indexesOf method returns the indexes of the given values
     *
     * @return void
     * @covers ::indexesOf
     */
    public function testIndexesOfReturnsExpected(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
            "string_2",
            "string_1",
        ]);

        $this->assertEquals([1, 3], $stringList->indexesOf("string_1"));
    }

    /**
     * Tests if the has method returns true if the value is found
     *
     * @return void
     * @covers ::has
     */
    public function testHasReturnsExpected(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $this->assertTrue($stringList->has("string_1"));
        $this->assertFalse($stringList->has("string_3"));
    }

    /**
     * Tests if the hasAny method returns true if any of the values is found
     *
     * @return void
     * @covers ::hasAny
     */
    public function testHasAnyReturnsExpected(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $this->assertTrue($stringList->hasAny("string_1", "string_3"));
        $this->assertFalse($stringList->hasAny("string_3", "string_4"));
    }

    /**
     * Tests if the hasAll method returns true if all values found
     *
     * @return void
     * @covers ::hasAny
     */
    public function testHasAllReturnsExpected(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $this->assertTrue($stringList->hasAll("string_1", "string_2"));
        $this->assertFalse($stringList->hasAll("string_0", "string_1", "string_2", "string_3"));
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
            "string_0",
            "string_1",
            "string_2",
        ];
        $stringList = new StringList($expected);

        $expected[] = "string_3";
        $stringList->append("string_3");

        $this->assertEquals($expected, $stringList->values());
    }

    /**
     * Tests if the isFull method returns true if the array is full
     *
     * @return void
     * @covers ::isFull
     */
    public function testIsFullReturnsTrue(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
            "string_2",
        ], 3);

        $this->assertTrue($stringList->isFull());
    }

    /**
     * Tests if the isFull method returns false if the array is not full
     *
     * @return void
     * @covers ::isFull
     */
    public function testIsFullReturnsFalse(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
        ], 3);

        $this->assertFalse($stringList->isFull());
    }

    /**
     * Tests if the left method returns the capacity left
     *
     * @return void
     * @covers ::left
     */
    public function testLeft(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
        ], 3);

        $this->assertEquals(1, $stringList->left());
    }

    /**
     * Tests if the length method returns the length of the array
     *
     * @return void
     * @covers ::length
     */
    public function testLength(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
        ]);

        $this->assertEquals(2, $stringList->length());
    }

    /**
     * Tests if the increaseCapacity method increases the capacity of the array
     *
     * @return void
     * @covers ::increaseCapacity
     */
    public function testIncreaseCapacity(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
        ]);

        $stringList
            ->append("string_2")
            ->append("string_3")
            ->append("string_4")
        ;
        $this->assertEquals(3, $stringList->left());

        $stringList->append("string_5");
        $this->assertEquals(2, $stringList->left());

        $stringList
            ->append("string_6")
            ->append("string_7")
            ->append("string_8")
        ;
        $this->assertEquals(7, $stringList->left());
    }

    /**
     * Tests if the capacity method returns the capacity of the array
     *
     * @return void
     * @covers ::capacity
     */
    public function testCapacity(): void
    {
        $stringList = new StringList([
            "string_0",
            "string_1",
        ], 3);

        $this->assertEquals(3, $stringList->capacity());

        $stringList->append("string_2");
        $this->assertEquals(3, $stringList->capacity());
    }

    /**
     * Tests if the unique method makes the array with unique values
     *
     * @return void
     * @covers ::unique
     */
    public function testUnique(): void
    {
        $floatList = new StringList([
            "string_0",
            "string_2",
            "string_1",
            "string_1",
        ]);

        $this->assertEquals([
            "string_0",
            "string_2",
            "string_1",
        ], $floatList->unique()->values());
    }

    /**
     * Tests if the filter method filters the array by callback
     *
     * @return void
     * @covers ::unique
     */
    public function testFilter(): void
    {
        $floatList = new StringList([
            "string 0",
            "string  1",
            "string2",
            "string_3",
        ]);

        $floatList->filter(static function($value) {
            return !preg_match('/\s/', $value);
        });

        $this->assertEquals([
            "string2",
            "string_3",
        ], $floatList->values());
    }

    /**
     * Tests if the sort method sorts the array by callback
     *
     * @return void
     * @covers ::sort
     */
    public function testSort(): void
    {
        $floatList = new StringList([
            "banana",
            "Banana",
            "orange",
            "ORANGE",
            "apple"
        ]);

        $this->assertEquals([
            "Banana",
            "ORANGE",
            "apple",
            "banana",
            "orange",
        ], $floatList->sort()->values());
    }
}



<?php

namespace Sitnikovik\Test\TypeList;

use InvalidArgumentException;
use OutOfBoundsException;
use OverflowException;
use Sitnikovik\FlexArray\TypeList\MixedList;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Test for MixedList
 */
class MixedListTest extends TestCase
{
    /**
     * Tests if the __construct method throws an exception on providing invalid data
     *
     * @return void
     * @covers ::__construct
     */
    public function test__constructNotThrowsExceptionOnInvalidData(): void
    {
        new MixedList([
            1,
            "1",
            [],
            true,
            null,
            new stdClass()
        ]);

        $this->assertTrue(true);
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

        new MixedList([1, "1"], 1);
    }

    /**
     * Tests if the append method appends any value to the array
     *
     * @return void
     * @covers ::append
     */
    public function testAppend(): void
    {
        $mixedList = new MixedList();

        $this->assertEquals(0, $mixedList->length());

        $mixedList
            ->append('string1')
            ->append(100)
            ->append(100.5)
            ->append(new stdClass())
            ->append(true)
            ->append(null)
        ;

        $this->assertEquals(6, $mixedList->length());
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

        $mixedList = new MixedList([
            "string_0",
            "string_1",
            "string_2",
        ], 3);

        $mixedList->append(1);
    }

    /**
     * Tests if the get method returns the value at the given index
     *
     * @return void
     * @covers ::get
     */
    public function testGet(): void
    {
        $mixedList = new MixedList([
            false,
            "string_1",
            null,
        ]);

        $this->assertFalse($mixedList->get(0));
        $this->assertEquals(null, $mixedList->get(2));
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

        $mixedList = new MixedList([
            "string_0",
            false,
            null,
        ]);

        $mixedList->get(3);
    }

    /**
     * Tests if the get method not throws an exception on no existing index
     *
     * @return void
     * @covers ::get
     */
    public function testGetNotThrowsExceptionOnArrayIndexDoesNotExist(): void
    {
        $mixedList = new MixedList([
            0 => "string_0",
            2 => null,
        ]);

        $this->assertEquals(null, $mixedList->get(1));
    }

    /**
     * Tests if the remove method removes the value at the given index
     *
     * @return void
     * @covers ::remove
     */
    public function testRemove(): void
    {
        $mixedList = new MixedList([
            "string_0",
            "string_1",
            null,
        ]);

        $mixedList->remove(2);

        $this->assertEquals(2, $mixedList->length());
        $this->assertEquals("string_0", $mixedList->get(0));
        $this->assertEquals("string_1", $mixedList->get(1));
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

        $mixedList = new MixedList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $mixedList->remove(3);
    }

    /**
     * Tests if the remove method not throws an exception on no existing index
     *
     * @return void
     * @covers ::remove
     */
    public function testRemoveNotThrowsExceptionOnArrayIndexDoesNotExist(): void
    {
        $mixedList = new MixedList([
            0 => null,
            2 => "string_2",
        ]);

        $mixedList->remove(1);

        $this->assertEquals(1, $mixedList->length());
        $this->assertEquals(null, $mixedList->get(0));
    }

    /**
     * Tests if the replace method replaces the value at the given index
     *
     * @return void
     * @covers ::replace
     */
    public function testReplace(): void
    {
        $mixedList = new MixedList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $mixedList->replace(1, false);
        $mixedList->replace(2, null);

        $this->assertEquals(3, $mixedList->length());
        $this->assertEquals("string_0", $mixedList->get(0));
        $this->assertFalse($mixedList->get(1));
        $this->assertEquals(null, $mixedList->get(2));
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

        $mixedList = new MixedList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $mixedList->replace(3, "string_3");
    }

    /**
     * Tests if the indexOf method returns the index of the given value
     *
     * @return void
     * @covers ::indexOf
     */
    public function testIndexOfReturnsIndexOfValue(): void
    {
        $mixedList = new MixedList([
            "string_0",
            false,
            null,
            false,
        ]);

        $this->assertEquals(1, $mixedList->indexOf(false));
        $this->assertEquals(1, $mixedList->indexOf(false));
        $this->assertEquals(2, $mixedList->indexOf(null));
    }

    /**
     * Tests if the indexOf method returns null if the value is not found
     *
     * @return void
     * @covers ::indexOf
     */
    public function testIndexOfReturnsNullIfValueNotFound(): void
    {
        $mixedList = new MixedList([
            "string_0",
            "string_1",
            "string_2",
        ]);

        $this->assertNull($mixedList->indexOf("string_3"));
    }

    /**
     * Tests if the indexesOf method returns the indexes of the given values
     *
     * @return void
     * @covers ::indexesOf
     */
    public function testIndexesOfReturnsExpected(): void
    {
        $mixedList = new MixedList([
            0,
            "0",
            null,
            false,
        ]);

        $this->assertEquals(
            [0, 1, 3],
            $mixedList->indexesOf(0, "0", false)
        );
    }

    /**
     * Tests if the has method returns true if the value is found
     *
     * @return void
     * @covers ::has
     */
    public function testHasReturnsExpected(): void
    {
        $mixedList = new MixedList([0, ""]);

        $this->assertTrue($mixedList->has(0));
        $this->assertFalse($mixedList->has(false));
    }

    /**
     * Tests if the hasAny method returns true if any of the values is found
     *
     * @return void
     * @covers ::hasAny
     */
    public function testHasAnyReturnsExpected(): void
    {
        $mixedList = new MixedList([
            0,
            "",
            "",
            false,
        ]);

        $this->assertTrue($mixedList->hasAny("", 0));
        $this->assertTrue($mixedList->hasAny(1, false));
        $this->assertFalse($mixedList->hasAny(1, null));
    }

    /**
     * Tests if the hasAll method returns true if all values found
     *
     * @return void
     * @covers ::hasAny
     */
    public function testHasAllReturnsExpected(): void
    {
        $mixedList = new MixedList([
            0,
            "",
            "",
            false,
        ]);

        $this->assertTrue($mixedList->hasAll(0, 0));
        $this->assertTrue($mixedList->hasAll(0, "", false));
        $this->assertFalse($mixedList->hasAll(0, 1, ""));
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
            0,
            "",
            null,
            null,
        ];
        $mixedList = new MixedList($expected);

        $expected[] = false;
        $mixedList->append(false);

        $this->assertEquals($expected, $mixedList->values());
    }

    /**
     * Tests if the isFull method returns true if the array is full
     *
     * @return void
     * @covers ::isFull
     */
    public function testIsFullReturnsTrue(): void
    {
        $mixedList = new MixedList([
            "string_0",
            null,
            "",
        ], 3);

        $this->assertTrue($mixedList->isFull());
    }

    /**
     * Tests if the isFull method returns false if the array is not full
     *
     * @return void
     * @covers ::isFull
     */
    public function testIsFullReturnsFalse(): void
    {
        $mixedList = new MixedList([
            "string_0",
            "string_1",
        ], 3);

        $this->assertFalse($mixedList->isFull());
    }

    /**
     * Tests if the isEmpty method returns true if the array is empty
     *
     * @return void
     * @covers ::isEmpty
     */
    public function testIsEmptyReturnsTrue(): void
    {
        $mixedList = new MixedList();

        $this->assertTrue($mixedList->isEmpty());
    }

    /**
     * Tests if the isEmpty method returns false if the array is not empty
     *
     * @return void
     * @covers ::isEmpty
     */
    public function testIsEmptyReturnsFalse(): void
    {
        $mixedList = new MixedList([
            "string_0",
            "string_1",
        ]);

        $this->assertFalse($mixedList->isEmpty());
    }

    /**
     * Tests if the left method returns the capacity left
     *
     * @return void
     * @covers ::left
     */
    public function testLeft(): void
    {
        $mixedList = new MixedList([
            null,
            "",
        ], 3);

        $this->assertEquals(1, $mixedList->left());
    }

    /**
     * Tests if the length method returns the length of the array
     *
     * @return void
     * @covers ::length
     */
    public function testLength(): void
    {
        $mixedList = new MixedList([
            "",
            false,
        ]);

        $this->assertEquals(2, $mixedList->length());
    }

    /**
     * Tests if the increaseCapacity method increases the capacity of the array
     *
     * @return void
     * @covers ::increaseCapacity
     */
    public function testIncreaseCapacity(): void
    {
        $mixedList = new MixedList([
            "string_0",
            "string_1",
        ]);

        $mixedList
            ->append("string_2")
            ->append("string_3")
            ->append("string_4")
        ;
        $this->assertEquals(3, $mixedList->left());

        $mixedList->append("string_5");
        $this->assertEquals(2, $mixedList->left());

        $mixedList
            ->append("string_6")
            ->append("string_7")
            ->append("string_8")
        ;
        $this->assertEquals(7, $mixedList->left());
    }

    /**
     * Tests if the capacity method returns the capacity of the array
     *
     * @return void
     * @covers ::capacity
     */
    public function testCapacity(): void
    {
        $mixedList = new MixedList([
            "string_0",
            "string_1",
        ], 3);

        $this->assertEquals(3, $mixedList->capacity());

        $mixedList->append("string_2");
        $this->assertEquals(3, $mixedList->capacity());
    }

    /**
     * Tests if the unique method makes the array with unique values
     *
     * @return void
     * @covers ::unique
     */
    public function testUnique(): void
    {
        $floatList = new MixedList([
            "string",
            "String",
            false,
            0,
            false,
            null,
            null,
            null,
        ]);

        $this->assertEquals([
            "string",
            "String",
            false,
            0,
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
        $input = [
            "string 0",
            " ",
            "",
            0,
            false,
            null,
        ];

        $floatList = new MixedList($input);
        $this->assertEquals([
            "string 0",
            " ",
        ], $floatList->filter()->values());

        $floatList = new MixedList($input);
        $floatList->filter(static function ($item) {
            return (is_string($item) && !empty($item)) || is_int($item);
        });
        $this->assertEquals([
            "string 0",
            " ",
            0,
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
        $floatList = new MixedList([
            "banana",
            "apple",
            "Banana",
            "orange",
            "ORANGE",
            false,
            0,
            ['a' => 'b'],
        ]);

        $this->assertEquals([
            false,
            0,
            "Banana",
            "ORANGE",
            "apple",
            "banana",
            "orange",
            ['a' => 'b'],
        ], $floatList->sort()->values());
    }
}

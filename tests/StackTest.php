<?php

namespace Sitnikovik\Test;

use OverflowException;
use Sitnikovik\FlexArray\Stack;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Sitnikovik\FlexArray\Stack
 */
class StackTest extends TestCase
{
    /**
     * Tests constructor failed on data bigger than capacity.
     *
     * @return void
     */
    public function testConstructorFailedOnDataBiggerThanCapacity(): void
    {
        $this->expectException(OverflowException::class);
        new Stack(1, ["foo", "bar"]);
    }

    /**
     * Tests isFull method on no data provided.
     * Should return false cause capacity is 0.
     *
     * @return void
     */
    public function testIsFullOnNoDataProvided(): void
    {
        $stack = new Stack();
        $this->assertFalse($stack->isFull());
    }

    /**
     * Tests isFull method on data and capacity provided.
     * Should return true if size is equal to capacity.
     *
     * @return void
     */
    public function testIsFullOnDataAndCapacityProvided(): void
    {
        $stack = new Stack(0);
        $this->assertFalse($stack->isFull());

        $stack = new Stack(1);
        $this->assertFalse($stack->isFull());
        $stack->push("test");
        $this->assertTrue($stack->isFull());
    }

    /**
     * Tests capacity method.
     * Should return 0 if no capacity provided.
     * Should return capacity if capacity provided.
     *
     * @return void
     */
    public function testCapacity(): void
    {
        $stack = new Stack();
        $this->assertEquals(0, $stack->capacity());

        $stack = new Stack(1);
        $this->assertEquals(1, $stack->capacity());
    }

    /**
     * Tests push method.
     * Should push item to stack top.
     *
     * @return void
     */
    public function testPush(): void
    {
        $stack = new Stack();

        $values = [
            "test",
            1,
            ["test", 1],
            false
        ];
        foreach ($values as $value) {
            $stack->push($value);
            $this->assertEquals($value, $stack->peek());
        }
    }

    /**
     * Tests push method failed on overflowed.
     *
     * @return void
     */
    public function testPushFailedOnOverflowed(): void
    {
        $stack = new Stack(1);

        $this->expectException(OverflowException::class);
        $stack->push("test_1");
        $stack->push("test_2");
    }

    /**
     * Tests push method.
     *
     * @return void
     */
    public function testPushFailedOnNotEmptyDataProvided(): void
    {
        $stack = new Stack(1, ["test"]);

        $this->expectException(OverflowException::class);
        $stack->push("test");
    }

    /**
     * Tests size method.
     *
     * @return void
     */
    public function testSize(): void
    {
        $stack = new Stack();
        $this->assertEquals(0, $stack->size());

        $stack->push("test");
        $this->assertEquals(1, $stack->size());

        foreach (["test", 1, ["test", 1], false] as $value) {
            $stack->push($value);
        }
        $this->assertEquals(5, $stack->size());
    }

    /**
     * Tests pop method.
     * Should return popped item.
     *
     * @return void
     */
    public function testPop(): void
    {
        $stack = new Stack(1, ["test"]);
        $this->assertEquals("test", $stack->pop());
    }

    /**
     * Tests pop method failed on empty data provided.
     *
     * @return void
     */
    public function testPopFailedOnEmptyDataProvided(): void
    {
        $stack = new Stack();

        $this->expectException(OverflowException::class);
        $stack->pop();
    }

    /**
     * Tests peek method.
     * Should return peeked item.
     * Should not remove item from stack.
     *
     * @return void
     */
    public function testPeek(): void
    {
        $stack = new Stack(1, ["test"]);

        $this->assertEquals("test", $stack->peek());
        $this->assertEquals("test", $stack->peek());
    }

    /**
     * Tests isEmpty method with empty data provided.
     * Should return true.
     *
     * @return void
     */
    public function testIsEmptyOnEmptyDataProvided(): void
    {
        $stack = new Stack();
        $this->assertTrue($stack->isEmpty());

        $stack->push("test");
        $this->assertFalse($stack->isEmpty());

        $stack->pop();
        $this->assertTrue($stack->isEmpty());
    }

    /**
     * Tests isEmpty method with data provided.
     * Should return false.
     *
     * @return void
     */
    public function testIsEmptyOnDataProvided(): void
    {
        $stack = new Stack(1, ["test"]);
        $this->assertFalse($stack->isEmpty());
    }

    /**
     * Tests isEmpty method on 1/1 item popped.
     * Should return true.
     *
     * @return void
     */
    public function testIsEmptyOnPopped(): void
    {
        $stack = new Stack(1, ["test"]);
        $stack->pop();
        $this->assertTrue($stack->isEmpty());
    }

    /**
     * Tests available method on empty data provided.
     * Should return 0 cause capacity is 0.
     *
     * @return void
     */
    public function testAvailableOnEmptyDataProvided(): void
    {
        $stack = new Stack();
        $this->assertEquals(0, $stack->available());
    }

    /**
     * Tests available method on data provided except capacity.
     * Should return 0 cause capacity is 0.
     *
     * @return void
     */
    public function testAvailableOnDataProvidedExceptCapacity(): void
    {
        $stack = new Stack(1, ["test"]);
        $this->assertEquals(0, $stack->available());
    }

    /**
     * Tests available method on data and capacity provided.
     * Should return capacity - size.
     *
     * @return void
     */
    public function testAvailableOnDataAndCapacityProvided(): void
    {
        $stack = new Stack(1);
        $this->assertEquals(1, $stack->available());

        $stack->push("test");
        $this->assertEquals(0, $stack->available());

        $stack->pop();
        $this->assertEquals(1, $stack->available());
    }
}

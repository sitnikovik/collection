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
     * Tests isFull method
     *
     * @return void
     */
    public function testIsFull(): void
    {
        $stack = new Stack();
        $this->assertFalse($stack->isFull());

        $stack = new Stack([], 0);
        $this->assertFalse($stack->isFull());

        $stack = new Stack([], 1);
        $this->assertFalse($stack->isFull());

        $stack->push("test");
        $this->assertTrue($stack->isFull());
    }

    /**
     * Tests capacity method
     *
     * @return void
     */
    public function testCapacity(): void
    {
        $stack = new Stack();
        $this->assertEquals(0, $stack->capacity());

        $stack = new Stack([], 1);
        $this->assertEquals(1, $stack->capacity());
    }

    /**
     * Tests push method
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
     * Tests push method
     *
     * @return void
     */
    public function testPushFailedOnCapacityProvided(): void
    {
        $stack = new Stack([], 1);

        $this->expectException(OverflowException::class);
        $stack->push("test");
        $stack->push("test");
    }

    /**
     * Tests push method
     *
     * @return void
     */
    public function testPushFailedOnNotEmptyDataProvided(): void
    {
        $stack = new Stack(["test"]);

        $this->expectException(OverflowException::class);
        $stack->push("test");
    }

    /**
     * Tests size method
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

    public function testPop()
    {

    }

    public function testPeek()
    {

    }

    public function testIsEmpty()
    {

    }

    public function testAvailable()
    {

    }
}

<?php

namespace Sitnikovik\Test;

use InvalidArgumentException;
use OverflowException;
use Sitnikovik\FlexArray\Queue;
use PHPUnit\Framework\TestCase;
use UnderflowException;

/**
 * @coversDefaultClass \Sitnikovik\FlexArray\Queue
 */
class QueueTest extends TestCase
{
    /**
     * Tests available method is ok
     *
     * @return void
     */
    public function testAvailable(): void
    {
        $queue = new Queue(2, ["test"]);

        $this->assertEquals(1, $queue->available());
    }

    /**
     * Tests pop method is ok
     *
     * @return void
     */
    public function testPop(): void
    {
        $queue = new Queue(1, ["test"]);

        $this->assertEquals(1, $queue->size());
        $this->assertEquals("test", $queue->pop());
        $this->assertEquals(0, $queue->size());
    }

    /**
     * Tests pop method is failed with UnderflowException
     *
     * @return void
     */
    public function testPopFailedWithUnderflowException(): void
    {
        $this->expectException(UnderflowException::class);

        $queue = new Queue(1);
        $queue->pop();
    }

    /**
     * Tests isFull method is ok
     *
     * @return void
     */
    public function testIsFull(): void
    {
        $queue = new Queue(1, ["test"]);

        $this->assertTrue($queue->isFull());
    }

    /**
     * Tests capacity method is ok
     *
     * @return void
     */
    public function testCapacity(): void
    {
        $queue = new Queue(1);

        $this->assertEquals(1, $queue->capacity());
    }

    /**
     * Tests constructor is ok
     *
     * @return void
     */
    public function test__construct(): void
    {
        $queue = new Queue(1);
        $this->assertInstanceOf(Queue::class, $queue);

        $queue = new Queue(2, ["test"]);
        $this->assertInstanceOf(Queue::class, $queue);
    }

    /**
     * Tests constructor is failed with OverflowException
     *
     * @return void
     */
    public function test__constructOverflowExceptionThrown(): void
    {
        $this->expectException(OverflowException::class);

        new Queue(1, ["test", "test2"]);
    }

    /**
     * Tests constructor is failed with InvalidArgumentException
     *
     * @return void
     */
    public function test__constructInvalidCapacityProvided(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Queue(0);
    }

    /**
     * Tests push method is ok
     *
     * @return void
     */
    public function testPush(): void
    {
        $queue = new Queue(1);

        $this->assertEquals(0, $queue->size());
        $queue->push("test");
        $this->assertEquals(1, $queue->size());
    }

    /**
     * Tests push method is failed with OverflowException
     *
     * @return void
     */
    public function testPushFailedWithOverflowException(): void
    {
        $this->expectException(OverflowException::class);

        $queue = new Queue(1, ["test"]);
        $queue->push("test2");
    }

    /**
     * Tests isEmpty method returns true
     *
     * @return void
     */
    public function testIsEmptyReturnsTrue(): void
    {
        $queue = new Queue(1);

        $this->assertTrue($queue->isEmpty());
    }

    /**
     * Tests isEmpty method returns false
     *
     * @return void
     */
    public function testIsEmptyReturnsFalse(): void
    {
        $queue = new Queue(1);
        $queue->push("test");

        $this->assertFalse($queue->isEmpty());
    }

    /**
     * Tests size method is ok
     *
     * @return void
     */
    public function testSize(): void
    {
        $queue = new Queue(1);

        $this->assertEquals(0, $queue->size());
        $queue->push("test");
        $this->assertEquals(1, $queue->size());
    }

    /**
     * Tests peek method is ok
     *
     * @return void
     */
    public function testPeek(): void
    {
        $queue = new Queue(1, ["test"]);

        $this->assertEquals("test", $queue->peek());
        $this->assertEquals(1, $queue->size());
    }
}

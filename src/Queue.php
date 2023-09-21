<?php

namespace Sitnikovik\FlexArray;

use OverflowException;
use UnderflowException;

/**
 * Queue implementation
 */
class Queue
{
    /**
     * Current queue size
     *
     * @var int
     */
    protected $size;

    /**
     * Max queue capacity
     *
     * @var int
     */
    protected $capacity;

    /**
     * Queue items
     *
     * @var array
     */
    protected $items;

    /**
     * @param int $capacity Max queue capacity
     * @param array $items Initial queue items
     */
    public function __construct(int $capacity, array $items = [])
    {
        $this->size = count($items);
        $this->capacity = $capacity;
        $this->items = $items;
    }

    /**
     * Adds item to queue end
     *
     * @param mixed $item
     * @return void
     */
    public function push($item): void
    {
        if ($this->size === $this->capacity) {
            throw new OverflowException('Queue is full');
        }

        $this->items[] = $item;
        $this->size++;
    }

    /**
     * Returns item and removes it from queue
     *
     * @return mixed
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Queue is empty');
        }

        $item = $this->items[$this->size - 1];
        unset($this->items[$this->size - 1]);
        $this->size--;

        return $item;
    }

    /**
     * Returns item from queue end but not removes it
     *
     * @return mixed
     */
    public function peek()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Queue is empty');
        }

        return $this->items[$this->size - 1];
    }

    /**
     * Checks if queue is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->size === 0;
    }

    /**
     * Checks if queue is full
     *
     * @return bool
     */
    public function isFull(): bool
    {
        return $this->size === $this->capacity;
    }

    /**
     * Returns current queue size
     *
     * @return int
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * Returns queue capacity
     *
     * @return int
     */
    public function capacity(): int
    {
        return $this->capacity;
    }

    /**
     * Returns available queue size
     *
     * @return int
     */
    public function available(): int
    {
        return ($this->capacity !== 0) ? $this->capacity - $this->size : 0;
    }
}
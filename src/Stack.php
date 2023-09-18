<?php

namespace Sitnikovik\FlexArray;

use OverflowException;

/**
 * Stack implementation
 */
class Stack
{
    /**
     * Current stack size
     *
     * @var int
     */
    private $size;

    /**
     * Max stack capacity
     *
     * @var int
     */
    private $capacity;

    /**
     * Stack data
     *
     * @var array
     */
    private $data;

    /**
     * @param array $data
     * @param int|null $capacity
     */
    public function __construct(array $data = [], ?int $capacity = null)
    {
        $this->data = $data;
        $this->size = count($data);
        $this->capacity = $capacity ?? count($data) ?: 0;
    }

    /**
     * Pushes item to stack top
     *
     * @param mixed $item
     * @return void
     * @throws OverflowException
     */
    public function push($item): void
    {
        if ($this->isFull()) {
            throw new OverflowException('Stack is full');
        }

        $this->data[] = $item;
        $this->size++;
    }

    /**
     * Pops item from stack top
     *
     * @return mixed
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            throw new OverflowException('Stack is empty');
        }

        $item = $this->data[$this->size - 1];
        unset($this->data[$this->size - 1]);
        $this->size--;

        return $item;
    }

    /**
     * Peeks item from stack top but not removes it
     *
     * @return mixed
     */
    public function peek()
    {
        if ($this->isEmpty()) {
            throw new OverflowException('Stack is empty');
        }

        return $this->data[$this->size - 1];
    }

    /**
     * Returns current stack size
     *
     * @return int
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * Returns stack capacity
     *
     * @return int
     */
    public function capacity(): int
    {
        return $this->capacity;
    }

    /**
     * Returns available stack size left.
     * If capacity is 0 returns 0
     *
     * @return int
     */
    public function available(): int
    {
        return ($this->capacity !== 0) ? $this->capacity - $this->size : 0;
    }

    /**
     * Returns true if stack is full of items
     *
     * @return bool
     */
    public function isFull(): bool
    {
        return $this->capacity !== 0 && $this->size === $this->capacity;
    }

    /**
     * Returns true if stack is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->size === 0;
    }
}
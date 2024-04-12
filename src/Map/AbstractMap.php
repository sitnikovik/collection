<?php

namespace Sitnikovik\FlexArray\Map;

abstract class AbstractMap
{
    /**
     * Data storage
     *
     * @var array
     */
    protected $data = [];

    /**
     * Remove value by key
     *
     * @param string $key
     * @return void
     */
    public function remove(string $key): void
    {
        unset($this->data[$key]);
    }

    /**
     * Check if key exists
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Returns all keys
     *
     * @return string[]
     */
    public function keys(): array
    {
        return array_keys($this->data);
    }

    /**
     * Returns all values as array
     *
     * @return array
     */
    public function values(): array
    {
        return array_values($this->data);
    }

    /**
     * Returns count of stored pairs
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * Returns all pairs as associative array
     *
     * @return array
     * @deprecated Use pairs() instead
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * Returns all pairs as associative array
     *
     * @return array
     */
    public function pairs(): array
    {
        return $this->data;
    }

    /**
     * Clears all stored pairs
     *
     * @return void
     */
    public function clear(): void
    {
        $this->data = [];
    }

    /**
     * Check if map is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return count($this->data) === 0;
    }

    /**
     * Check if map is not empty
     *
     * @return bool
     * @deprecated Use isEmpty() instead
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }
}
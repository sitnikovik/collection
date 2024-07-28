<?php

namespace Sitnikovik\FlexArray\TypeList;

use InvalidArgumentException;
use OutOfBoundsException;
use OverflowException;

/**
 * Abstract class for typed array with int keys
 */
abstract class AbstractList
{
    /**
     * Data array
     *
     * @var array
     */
    protected $array;

    /**
     * Length of the array
     *
     * @var int
     */
    protected $length;

    /**
     * Capacity of the array
     *
     * @var int
     */
    protected $capacity;

    /**
     * Defines if the capacity is strict
     *
     * @var bool
     */
    private $isCapacityStrict = false;

    /**
     * Makes a new type array instance.
     *
     * The length and capacity are optional.
     * If the capacity is less than the array size, throws an exception.
     * If the capacity is not defined, it will be the double of the length.
     *
     * @param array $array
     * @param int $capacity
     */
    public function __construct(array $array = [], int $capacity = 0)
    {
        $length = count($array);
        if ($capacity > 0 && $capacity < $length) {
            throw new InvalidArgumentException('Capacity is less than the array size');
        }

        if (!$this->isArrayValid($array)) {
            throw new InvalidArgumentException('Array type is invalid');
        }

        $this->array = $length > 0 ? array_values($array) : $array;
        $this->length = $length;
        $this->capacity = $capacity ?: $this->length * 2;
        $this->isCapacityStrict = $capacity > 0;
    }

    /**
     * Defines is the provided array type valid
     *
     * @param array $array
     * @return void
     */
    abstract protected function isArrayValid(array $array): bool;

    /**
     * Appends a value to the array and increments the length.
     * If the array is full, throws an exception.
     *
     * @param mixed $value
     * @return $this
     */
    final protected function appendValue($value): self
    {
        if ($this->isFull()) {
            throw new OverflowException('Array is full of data');
        }

        $this->array[] = $value;
        $this->length++;

        $this->increaseCapacity();

        return $this;
    }

    /**
     * Returns value at the given index.
     * If the index is out of bounds, throws an exception.
     *
     * @param int $index
     * @return mixed
     */
    final protected function getByIndex(int $index)
    {
        if ($index < 0 || $index >= $this->length) {
            throw new OutOfBoundsException("Index \"$index\" out of bounds");
        }

        return $this->array[$index];
    }

    /**
     * Replaces the value at the given index.
     *
     * @param int $index
     * @param mixed $value
     * @return $this
     */
    final protected function replaceByIndex(int $index, $value): self
    {
        if ($index < 0 || $index >= $this->length) {
            throw new OutOfBoundsException("Index \"$index\" out of bounds");
        }

        $this->array[$index] = $value;

        return $this;
    }
    /**
     * Removes the value at the given index and decrements the length.
     * If the index is out of bounds, throws an exception.
     *
     * @param int $index
     * @return static
     */
    public function remove(int $index): self
    {
        if ($index < 0 || $index >= $this->length) {
            throw new OverflowException("Index \"$index\" out of bounds");
        }

        array_splice($this->array, $index, 1);
        $this->length--;

        return $this;
    }

    /**
     * Makes the array unique.
     * Removes all null values from the array.
     *
     * @param int $flags
     * @return $this
     */
    public function unique(int $flags = SORT_STRING): self
    {
        $this->array = array_values(array_unique($this->array, $flags));

        return $this;
    }

    /**
     * Filters the array using the given callback.
     * If the callback is null, removes all empty values from the array.
     *
     * @param callable|null $callback
     * @return $this
     */
    public function filter(?callable $callback = null): self
    {
        $this->array = array_values(array_filter($this->array, $callback));

        return $this;
    }

    /**
     * Sorts the array using the given callback.
     *
     * @param int $flags
     * @return static
     */
    public function sort(int $flags = SORT_REGULAR): self
    {
        sort($this->array, $flags);

        return $this;
    }

    /**
     * Returns the index of the first occurrence of the given value or null if not found.
     *
     * @param mixed $value
     * @return int|null
     */
    final protected function getIndexByValue($value): ?int
    {
        foreach ($this->array as $i => $item) {
            if ($item === $value) {
                return $i;
            }
        }

        return null;
    }

    /**
     * Returns the values of the array.
     *
     * @return array
     */
    final protected function getValues(): array
    {
        return $this->array;
    }

    /**
     * Returns the indexes of the given values.
     *
     * @param array $values
     * @return int[]
     */
    final protected function getIndexesOfValues(array $values): array
    {
        $indexes = [];
        $founds = [];

        foreach ($this->array as $i => $value) {
            foreach ($values as $val) {
                $k = $val < 0
                    ? (string)$val
                    : $val;
                if (is_float($k)) {
                    $k = (string)$k;
                }

                if (isset($founds[$k]) && $founds[$k] === $i) {
                    continue;
                }

                if ($value === $val) {
                    $indexes[] = $i;
                    $founds[$k] = $i;
                    break;
                }
            }
        }

        return $indexes;
    }

    /**
     * Checks if contains the given value.
     *
     * @param mixed $value
     * @return bool
     */
    final protected function hasValue($value): bool
    {
        return in_array($value, $this->array, true);
    }

    /**
     * Checks if contains any of the given values.
     *
     * @param array $values
     * @return bool
     */
    final protected function hasAnyValues(array $values): bool
    {
        foreach ($this->array as $item) {
            if (in_array($item, $values, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if contains all the given values.
     *
     * @param array $values
     * @return bool
     */
    final protected function hasAllValues(array $values): bool
    {
        $foundCount = 0;
        $founds = [];
        $uniqueValues = array_unique($values);
        foreach ($this->array as $item) {
            $k = $item < 0
                ? (string)$item
                : $item;
            if (is_float($k)) {
                $k = (string)$k;
            }
            if (!isset($founds[$k]) && in_array($item, $uniqueValues, true)) {
                $foundCount++;
                $founds[$k] = true;
            }
        }

        return $foundCount === count($uniqueValues);
    }

    /**
     * Checks if array is full of data
     *
     * @return bool
     */
    final public function isFull(): bool
    {
        return $this->isCapacityStrict && $this->left() === 0;
    }

    /**
     * Checks if array is empty
     *
     * @return bool
     */
    final public function isEmpty(): bool
    {
        return $this->length === 0;
    }

    /**
     * Returns capacity left
     *
     * @return int
     */
    final public function left(): int
    {
        return max($this->capacity - $this->length, 0);
    }

    /**
     * Increases capacity of the array
     *
     * @return void
     */
    final protected function increaseCapacity(): void
    {
        if (!$this->isCapacityStrict && $this->length >= $this->capacity) {
            $this->capacity *= 2;
        }
    }

    /**
     * Returns length of the array
     *
     * @return int
     */
    public function length(): int
    {
        return $this->length;
    }

    /**
     * Get capacity of the array
     *
     * @return int
     */
    public function capacity(): int
    {
        return $this->capacity;
    }
}
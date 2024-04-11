<?php

namespace Sitnikovik\FlexArray\TypeList;

use RuntimeException;

class IntList extends AbstractList
{
    /**
     * @inheritDoc
     * @return bool
     */
    protected function isArrayValid(array $array): bool
    {
        foreach ($array as $value) {
            if (!is_int($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the sum of all the values in the array.
     *
     * @return int
     */
    public function sum(): int
    {
        return (int)array_sum($this->array);
    }

    /**
     * Appends an int to the array and increments the length.
     * If the array is full, throws an exception.
     *
     * @param int $value
     * @return void
     */
    public function append(int $value): self
    {
        return $this->appendValue($value);
    }

    /**
     * Returns value at the given index.
     * If the index is out of bounds, throws an exception.
     *
     * @param int $index
     * @return int
     */
    public function get(int $index): int
    {
        return $this->getByIndex($index);
    }

    /**
     * Returns all the values.
     *
     * @return int[]
     */
    public function values(): array
    {
        return $this->getValues();
    }

    /**
     * Replaces the value at the given index.
     *
     * @param int $index
     * @param int $value
     * @return $this
     */
    public function replace(int $index, int $value): self
    {
        return $this->replaceByIndex($index, $value);
    }

    /**
     * Returns the index of the first occurrence of the given value or null if not found.
     *
     * @param int $value
     * @return int|null
     */
    public function indexOf(int $value): ?int
    {
        return $this->getIndexByValue($value);
    }

    /**
     * Returns the indexes of the given values.
     *
     * @param int ...$values
     * @return int[]
     */
    public function indexesOf(int ...$values): array
    {
        return $this->getIndexesOfValues($values);
    }

    /**
     * Checks if contains the given value.
     *
     * @param int $value
     * @return bool
     */
    public function has(int $value): bool
    {
        return $this->hasValue($value);
    }

    /**
     * Checks if contains any of the given values.
     *
     * @param int ...$values
     * @return bool
     */
    public function hasAny(int ...$values): bool
    {
        return $this->hasAnyValues($values);
    }

    /**
     * Checks if contains all the given values.
     *
     * @param int ...$values
     * @return bool
     */
    public function hasAll(int ...$values): bool
    {
        return $this->hasAllValues($values);
    }
}
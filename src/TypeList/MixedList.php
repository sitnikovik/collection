<?php

namespace Sitnikovik\FlexArray\TypeList;

use RuntimeException;

/**
 * Array int key indexed that stores any data
 */
class MixedList extends AbstractList
{
    /**
     * @inheritDoc
     * @return bool
     */
    protected function isArrayValid(array $array): bool
    {
        return true;
    }

    /**
     * Appends a value to the array and increments the length.
     * If the array is full, throws an exception.
     *
     * @param mixed $value
     * @return $this
     */
    public function append($value): self
    {
        return $this->appendValue($value);
    }

    /**
     * Returns the value at the given index.
     * If the index is out of bounds, throws an exception.
     *
     * @param int $index
     * @return mixed
     */
    public function get(int $index)
    {
        return $this->getByIndex($index);
    }

    /**
     * Returns all the values.
     *
     * @return array
     */
    public function values(): array
    {
        return $this->getValues();
    }

    /**
     * Replaces the value at the given index.
     *
     * @param int $index
     * @param mixed $value
     * @return $this
     */
    public function replace(int $index, $value): self
    {
        return $this->replaceByIndex($index, $value);
    }

    /**
     * Returns the index of the first occurrence of the given value or null if not found.
     *
     * @param mixed $value
     * @return int|null
     */
    public function indexOf($value): ?int
    {
        return $this->getIndexByValue($value);
    }

    /**
     * Returns the indexes of the given values.
     *
     * @param mixed ...$values
     * @return int[]
     */
    public function indexesOf(...$values): array
    {
        return $this->getIndexesOfValues($values);
    }

    /**
     * Checks if contains the given value.
     *
     * @param mixed $value
     * @return bool
     */
    public function has($value): bool
    {
        return $this->hasValue($value);
    }

    /**
     * Checks if contains any of the given values.
     *
     * @param mixed ...$values
     * @return bool
     */
    public function hasAny(...$values): bool
    {
        return $this->hasAnyValues($values);
    }

    /**
     * Checks if contains all the given values.
     *
     * @param mixed ...$values
     * @return bool
     */
    public function hasAll(...$values): bool
    {
        return $this->hasAllValues($values);
    }


}
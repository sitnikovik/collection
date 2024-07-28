<?php

namespace Sitnikovik\FlexArray\TypeList;

class FloatList extends AbstractList
{
    /**
     * @inheritDoc
     * @return bool
     */
    protected function isArrayValid(array $array): bool
    {
        foreach ($array as $value) {
            if (!is_float($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the sum of all the values in the array.
     *
     * @return float
     */
    public function sum(): float
    {
        return (float)array_sum($this->array);
    }

    /**
     * Appends a float to the array and increments the length.
     * If the array is full, throws an exception.
     *
     * @param float $value
     * @return $this
     */
    public function append(float $value): self
    {
        return $this->appendValue($value);
    }

    /**
     * Returns value at the given index.
     * If the index is out of bounds, throws an exception.
     *
     * @param int $index
     * @return float
     */
    public function get(int $index): float
    {
        return $this->getByIndex($index);
    }

    /**
     * Returns all the values.
     *
     * @return float[]
     */
    public function values(): array
    {
        return $this->getValues();
    }

    /**
     * Replaces the value at the given index.
     *
     * @param int $index
     * @param float $value
     * @return $this
     */
    public function replace(int $index, float $value): self
    {
        return $this->replaceByIndex($index, $value);
    }

    /**
     * Returns the index of the first occurrence of the given value or null if not found.
     *
     * @param float $value
     * @return int|null
     */
    public function indexOf(float $value): ?int
    {
        return $this->getIndexByValue($value);
    }

    /**
     * Returns the indexes of the given values.
     *
     * @param float ...$values
     * @return float[]
     */
    public function indexesOf(float ...$values): array
    {
        return $this->getIndexesOfValues($values);
    }

    /**
     * Checks if contains the given value.
     *
     * @param float $value
     * @return bool
     */
    public function has(float $value): bool
    {
        return $this->hasValue($value);
    }

    /**
     * Checks if contains any of the given values.
     *
     * @param float ...$values
     * @return bool
     */
    public function hasAny(float ...$values): bool
    {
        return $this->hasAnyValues($values);
    }

    /**
     * Checks if contains all the given values.
     *
     * @param float ...$values
     * @return bool
     */
    public function hasAll(float ...$values): bool
    {
        return $this->hasAllValues($values);
    }
}
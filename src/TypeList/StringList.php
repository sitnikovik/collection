<?php

namespace Sitnikovik\FlexArray\TypeList;

/**
 * Array int key indexed that stores strings
 */
class StringList extends AbstractList
{
    /**
     * @inheritDoc
     * @return bool
     */
    protected function isArrayValid(array $array): bool
    {
        foreach ($array as $value) {
            if (!is_string($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Appends a string to the array and increments the length.
     * If the array is full, throws an exception.
     *
     * @param string $value
     * @return $this
     */
    public function append(string $value): self
    {
        return $this->appendValue($value);
    }

    /**
     * Returns value at the given index.
     * If the index is out of bounds, throws an exception.
     *
     * @param int $index
     * @return string
     */
    public function get(int $index): string
    {
        return $this->getByIndex($index);
    }

    /**
     * Returns all the values.
     *
     * @return string[]
     */
    public function values(): array
    {
        return $this->getValues();
    }

    /**
     * Replaces the value at the given index.
     *
     * @param int $index
     * @param string $value
     * @return $this
     */
    public function replace(int $index, string $value): self
    {
        return $this->replaceByIndex($index, $value);
    }

    /**
     * Returns the index of the first occurrence of the given value or null if not found.
     *
     * @param string $value
     * @return int|null
     */
    public function indexOf(string $value): ?int
    {
        return $this->getIndexByValue($value);
    }

    /**
     * Returns the indexes of the given values.
     *
     * @param string ...$values
     * @return int[]
     */
    public function indexesOf(string ...$values): array
    {
        return $this->getIndexesOfValues($values);
    }

    /**
     * Checks if contains the given value.
     *
     * @param string $value
     * @return bool
     */
    public function has(string $value): bool
    {
        return $this->hasValue($value);
    }

    /**
     * Checks if contains any of the given values.
     *
     * @param string ...$values
     * @return bool
     */
    public function hasAny(string ...$values): bool
    {
        return $this->hasAnyValues($values);
    }

    /**
     * Checks if contains all the given values.
     *
     * @param string ...$values
     * @return bool
     */
    public function hasAll(string ...$values): bool
    {
        return $this->hasAllValues($values);
    }
}
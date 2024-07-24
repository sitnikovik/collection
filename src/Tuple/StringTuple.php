<?php

namespace Sitnikovik\FlexArray\Tuple;

/**
 * Tuple with string values
 */
class StringTuple extends AbstractTuple 
{
    /**
     * @inheritDoc
     * @return bool
     */
    protected function isValueValid(mixed $value): bool
    {
        return is_string($value);
    }

    /**
     * Returns value at the given index.
     * If the index is out of bounds, throws an exception.
     *
     * @param int $index
     * @return string|null
     */
    public function get(int $index): ?string
    {
        return $this->getByIndex($index);
    }

    /**
     * Returns all the values.
     *
     * @return string[]
     */
    public function all(): array
    {
        return $this->getAll();
    }
}
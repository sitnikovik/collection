<?php

namespace Sitnikovik\FlexArray\Tuple;

/**
 * Tuple with integer values
 */
class IntTuple extends AbstractTuple 
{
    /**
     * @inheritDoc
     * @return bool
     */
    protected function isValueValid(mixed $value): bool
    {
        return is_int($value);
    }

    /**
     * Returns value at the given index.
     * If the index is out of bounds, throws an exception.
     *
     * @param int $index
     * @return mixed|null
     */
    public function get(int $index): ?int
    {
        return $this->getByIndex($index);
    }

    /**
     * Returns all the values.
     *
     * @return int[]
     */
    public function all(): array
    {
        return $this->getAll();
    }
}
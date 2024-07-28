<?php

namespace Sitnikovik\FlexArray\Tuple;

/**
 * Tuple with float values
 */
class FloatTuple extends AbstractTuple 
{
    /**
     * @inheritDoc
     * @return bool
     */
    protected function isValueValid(mixed $value): bool
    {
        return is_float($value);
    }
    
    /**
     * Returns value at the given index.
     * If the index is out of bounds, throws an exception.
     *
     * @param int $index
     * @return float|null
     */
    public function get(int $index): ?float
    {
        return $this->getByIndex($index);
    }

    /**
     * Returns all the values.
     *
     * @return float[]
     */
    public function all(): array
    {
        return $this->getAll();
    }
}
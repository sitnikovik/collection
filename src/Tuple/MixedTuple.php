<?php

namespace Sitnikovik\FlexArray\Tuple;

/**
 * Tuple with mixed values
 */
class MixedTuple extends AbstractTuple 
{
    /**
     * @inheritDoc
     * @return bool
     */
    protected function isValueValid(mixed $value): bool
    {
        return true;
    }

    /**
     * Returns value at the given index.
     * If the index is out of bounds, throws an exception.
     *
     * @param int $index
     * @return mixed|null
     */
    public function get(int $index): mixed
    {
        return $this->getByIndex($index);
    }

    /**
     * Returns all the values.
     *
     * @return mixed[]
     */
    public function all(): array
    {
        return $this->getAll();
    }
}
<?php

namespace Sitnikovik\FlexArray\Tuple;

use InvalidArgumentException;

/**
 * Immutable list impementation
 */
abstract class AbstractTuple 
{
    /**
     * Data storage
     *
     * @var array
     */
    protected $data = [];
    
    /**
     * Immutable list constructor
     * 
     * @param mixed[] $data
     * @throws InvalidArgumentException
     */
    public function __construct(array $data)
    {
        $values = [];
        $n = count($data);
        for ($i = 0; $i < $n; $i++) {
            if (!$this->isValueValid($data[$i])) {
                throw new InvalidArgumentException('Invalid value at index ' . $i);
            }
            $values[] = $data[$i];
        }

        $this->data = $values;
    }

    /**
     * Check if the value is valid
     */
    protected abstract function isValueValid(mixed $value): bool;

    /**
     * Get value by index
     *
     * @param int $index
     * @return mixed|null
     */
    protected function getByIndex(int $index): mixed
    {
        return $this->data[$index] ?? null;
    }

    /**
     * Returns all values
     *
     * @return mixed[]
     */
    protected function getAll(): array
    {
        return $this->data;
    }
}
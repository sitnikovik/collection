<?php

namespace Sitnikovik\FlexArray\Map;

/**
 * Map realization that stores float values
 */
class FloatMap extends AbstractMap
{
    /**
     * Get value by key
     *
     * @param string $key
     * @return float|null
     */
    public function get(string $key): ?float
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Set value by key
     *
     * @param string $key
     * @param float $value
     * @return void
     */
    public function set(string $key, float $value): void
    {
        $this->data[$key] = $value;
    }
}
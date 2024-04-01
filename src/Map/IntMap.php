<?php

namespace Sitnikovik\FlexArray\Map;

/**
 * Map realization that stores integer values
 */
class IntMap extends AbstractMap
{
    /**
     * Get value by key
     *
     * @param string $key
     * @return int|null
     */
    public function get(string $key): ?int
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Set value by key
     *
     * @param string $key
     * @param int $value
     * @return void
     */
    public function set(string $key, int $value): void
    {
        $this->data[$key] = $value;
    }
}
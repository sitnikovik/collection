<?php

namespace Sitnikovik\FlexArray\Map;

/**
 * Map realization that stores string values
 */
class StringMap extends AbstractMap
{
    /**
     * Get value by key
     *
     * @param string $key
     * @return string|null
     */
    public function get(string $key): ?string
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Set value by key
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function set(string $key, string $value): void
    {
        $this->data[$key] = $value;
    }
}
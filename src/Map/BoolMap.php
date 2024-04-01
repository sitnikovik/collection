<?php

namespace Sitnikovik\FlexArray\Map;

/**
 * Map realization that stores boolean values
 */
class BoolMap extends AbstractMap
{
    /**
     * Get value by key
     *
     * @param string $key
     * @return bool|null
     */
    public function get(string $key): ?bool
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Set value by key
     *
     * @param string $key
     * @param bool $value
     * @return void
     */
    public function set(string $key, bool $value): void
    {
        $this->data[$key] = $value;
    }
}
<?php

namespace Sitnikovik\FlexArray;

use Sitnikovik\FlexArray\Map\AbstractMap;

/**
 * Map realization that stores mixed values
 */
class MixedMap extends AbstractMap
{
    /**
     * Get value by key
     *
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Set value by key
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }
}
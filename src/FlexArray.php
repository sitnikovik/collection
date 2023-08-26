<?php

namespace Sitnikovik\FlexArray;

use Exception;

class FlexArray
{
    /**
     * Array to be processed.
     *
     * @var array
     */
    protected $haystack;

    /**
     * @param array $haystack
     */
    public function __construct(array $haystack)
    {
        $this->haystack = $haystack;
    }

    /**
     * Returns value by `$key`.
     *
     * If value not exists the `$default` returns.
     *
     * @param string|int $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return $this->haystack[$key] ?? $default;
    }

    /**
     * Returns the haystack.
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->haystack;
    }

    /**
     * Return keys of the haystack.
     *
     * @return int[]|string[]
     */
    public function getKeys(): array
    {
        return array_keys($this->getAll());
    }

    /**
     * Returns all haystack values but declared in `$keys`
     *
     * @param int|string ...$keys
     * @return array
     */
    public function getAllBut(...$keys): array
    {
        $haystack = $this->haystack;
        foreach ($keys as $arg) {
            if (isset($haystack[$arg])) {
                unset($haystack[$arg]);
            }
        }

        return $haystack;
    }

    /**
     * Returns list of integer values indexed by its keys.
     *
     * @return array
     */
    public function getAllIntegers(): array
    {
        $filtered = [];
        foreach ($this->getAll() as $key => $value) {
            if (is_int($value)) {
                $filtered[$key] = $value;
            }
        }

        return $filtered;
    }

    /**
     * Returns list of string values indexed by its keys.
     *
     * @return array
     */
    public function getAllStrings(): array
    {
        $filtered = [];
        foreach ($this->getAll() as $key => $value) {
            if (is_string($value)) {
                $filtered[$key] = $value;
            }
        }

        return $filtered;
    }

    /**
     * Returns list of boolean values indexed by its keys.
     *
     * @return array
     */
    public function getAllBooleans(): array
    {
        $filtered = [];
        foreach ($this->getAll() as $key => $value) {
            if (is_bool($value)) {
                $filtered[$key] = $value;
            }
        }

        return $filtered;
    }

    /**
     * Returns the haystack of not real empty values.
     *
     * @return array
     */
    public function getAllNotEmpty(): array
    {
        $isEmpty = [];
        foreach ($this->getAll() as $key => $value) {
            if (!$this->isEmpty($key)) {
                $isEmpty[$key] = $value;
            }
        }

        return $isEmpty;
    }

    /**
     * Returns the first element.
     *
     * @return mixed
     */
    public function getFirst()
    {
        return $this->haystack[$this->getFirstKey()];
    }

    /**
     * Returns first key of the haystack or null on empty haystack.
     *
     * @return int|string|null
     */
    public function getFirstKey()
    {
        if (!empty($this->haystack)) {
            return array_key_first($this->haystack);
        }

        return null;
    }

    /**
     * Returns the last element.
     *
     * @return mixed
     */
    public function getLast()
    {
        return $this->haystack[$this->getLastKey()];
    }

    /**
     * Returns last key of the haystack.
     *
     * @return int|string|null
     */
    public function getLastKey()
    {
        $count = $this->count();
        $i = 1;

        foreach ($this->haystack as $key => $value) {
            if ($i === $count) {
                return $key;
            }
            $i++;
        }

        return null;
    }

    /**
     * Returns value by index.
     *
     * Pass negative number for reverse search.
     *
     * @param $index
     * @return mixed|null
     */
    public function getByIndex($index)
    {
        if (!$this->inCount($index)) {
            return null;
        }

        $i = 0;
        $haystack = ($index >= 0) ? $this->getAll() : array_reverse($this->getAll());

        foreach ($haystack as $value) {
            if ($i === $index) {
                return $value;
            }
            $i = ($index >= 0) ? $i + 1 : $i - 1;
        }

        return null;
    }

    /**
     * Returns values up to `$index`.
     *
     * @param int $index
     * @return array
     */
    public function getUpTo(int $index): array
    {
        $i = 0;
        $haystack = ($index >= 0) ? $this->getAll() : array_reverse($this->getAll());
        $values = [];

        foreach ($haystack as $key => $value) {
            $condition = ($index >= 0) ? ($i <= $index) : ($i >= $index);
            if ($condition) {
                $values[$key] = $value;
                $i = ($index >= 0) ? $i + 1 : $i - 1;
            } else {
                break;
            }
        }

        return $values;
    }

    /**
     * Represents the haystack and all its values (only if it is not iterable in string).
     *
     * Pass `true` in `$associative` to represent in indexed by its keys.
     *
     * @param string $separator
     * @param bool $associative
     * @return string
     */
    public function implodeAll(string $separator, bool $associative = false): string
    {
        $result = [];
        foreach ($this->haystack as $key => $value) {
            $value = (is_object($value)) ? (array)$value : $value;

            if (!is_array($value)) {
                $result[] = (($associative) ? sprintf('%s: %s', $key, $value) : $value);
            } else {
                $result[] = self::join($separator, $value, $associative);
            }
        }

        return implode($separator, $result);
    }

    /**
     * Returns only scalar values in the haystack as string.
     *
     * Pass `true` in `$associative` to represent in indexed by its keys.
     *
     * @param string $separator
     * @param bool $associative
     * @return string
     */
    public function implode(string $separator, bool $associative = false): string
    {
        $strings = [];
        foreach ($this->haystack as $key => $value) {
            if (is_scalar($value)) {
                $strings[] = ($associative)
                    ? sprintf('%s: %s', $key, $value)
                    : $value;
            }
        }

        return implode($separator, $strings);
    }

    /**
     * Returns haystack keys as string.
     *
     * @param string $separator
     * @return string
     */
    public function implodeKeys(string $separator): string
    {
        return implode($separator, $this->getKeys());
    }

    /**
     * Returns the haystack length.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->haystack);
    }

    /**
     * Returns key of value in the haystack or null on found.
     *
     * @param mixed $needle
     * @return int|string|null
     */
    public function keyOf($needle)
    {
        foreach ($this->haystack as $key => $value) {
            if ($value === $needle) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Returns list of keys for haystack values.
     *
     * @param mixed ...$needles
     * @return array
     */
    public function keysOf(...$needles): array
    {
        $keys = [];
        foreach ($this->haystack as $key => $value) {
            if (in_array($value, $needles, true)) {
                $keys[] = $key;
            }
        }

        return $keys;
    }

    /**
     * Returns integer index of value.
     *
     * @param mixed $needle
     * @return int|null
     */
    public function indexOf($needle): ?int
    {
        $i = 0;
        foreach ($this->haystack as $value) {
            if ($value === $needle) {
                return $i;
            }
            $i++;
        }

        return null;
    }

    /**
     * Returns list of integer indexes of provided values.
     *
     * @param mixed ...$needles
     * @return array
     */
    public function indexesOf(...$needles): array
    {
        $i = 0;
        $indexes = [];
        foreach ($this->haystack as $value) {
            if (in_array($value, $needles, true)) {
                $indexes[] = $i;
            }
            $i++;
        }

        return $indexes;
    }

    /**
     * Return integer index of key.
     *
     * @param int|string $needle
     * @return int|null
     */
    public function indexOfKey($needle): ?int
    {
        $i = 0;
        foreach ($this->haystack as $key => $value) {
            if ($key === $needle) {
                return $i;
            }
            $i++;
        }

        return null;
    }

    /**
     * Returns key of integer index in the haystack or `null` on not found.
     *
     * @param int $index
     * @return int|string|null
     */
    public function getKeyOfIndex(int $index)
    {
        if (!$this->inCount($index)) {
            return null;
        }

        $haystack = ($index < 0) ? array_reverse($this->getAll()) : $this->getAll();
        $i = 0;

        foreach ($haystack as $key => $value) {
            if ($i === $index) {
                return $key;
            }
            $i = ($index < 0) ? $i - 1 : $i + 1;
        }

        return null;
    }

    /**
     * Binary search method for integer value in haystack.
     *
     * Sorts the haystack due the process.
     *
     * Returns the integer index of value on found or null on not.
     *
     * | Note that it works only with integer values.
     *
     * @param int $needle
     * @return int|null
     */
    public function binarySearch(int $needle): ?int
    {
        if (empty($this->haystack)) {
            return null;
        }

        $haystack = $this->haystack;
        sort($haystack);

        $len = count($this->haystack);
        $lower = 0;
        $high = $len - 1;
        while ($lower <= $high) {
            $middle = (int)(($lower + $high) / 2);
            if ($haystack[$middle] > $needle) {
                $high = $middle - 1;
            } else if ($haystack[$middle] < $needle) {
                $lower = $middle + 1;
            } else {
                return $middle;
            }
        }

        return null;
    }

    /**
     * Implodes `$haystack`.
     *
     * Pass `true` in `$associative` to represent in indexed by its keys.
     *
     * @param string $separator
     * @param array $haystack
     * @param bool $associative
     * @return string
     */
    private static function join(string $separator, array $haystack, bool $associative = false): string
    {
        $string = [];
        foreach ($haystack as $key => $value) {
            if (!is_scalar($value) && !is_array($value)) {
                continue;
            }

            if (is_scalar($value)) {
                $string[] = (($associative) ? sprintf('%s: %s', $key, $value) : $value);
            } else {
                $string[] = self::join($separator, $value, $associative);
            }
        }

        return implode($separator, $string);
    }

    /**
     * Represents haystack in JSON string content.
     *
     * @return string
     * @throws Exception
     */
    public function toJson(): string
    {
        $haystack = $this->getAll();

        return json_encode($haystack, JSON_THROW_ON_ERROR);
    }

    /**
     * Returns list of keys of not real empty values.
     *
     * @param int|string ...$keys
     * @return array
     */
    public function touch(...$keys): array
    {
        $filtered = [];

        foreach ($keys as $key) {
            if (!$this->isEmpty($key)) {
                $filtered[$key] = $this->get($key);
            }
        }

        return $filtered;
    }

    /**
     * Returns list of found values associated with found keys in haystack.
     *
     * @param mixed ...$values
     * @return array
     */
    public function findValues(...$values): array
    {
        $filtered = [];
        foreach ($values as $value) {
            foreach ($this->haystack as $key => $_value) {
                if ($value === $_value) {
                    $filtered[$key] = $_value;
                }
            }
        }

        return $filtered;
    }

    /**
     * Sets value by `$key`.
     *
     * @param string|int $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value): self
    {
        $this->haystack[$key] = $value;

        return $this;
    }

    /**
     * Adds value to haystack to the top of haystack.
     *
     * @param mixed $value
     * @return $this
     */
    public function prepend($value): self
    {
        array_unshift($this->haystack, $value);

        return $this;
    }

    /**
     * Adds value to haystack in the end.
     *
     * @param mixed $value
     * @return $this
     */
    public function append($value): self
    {
        $this->haystack[] = $value;

        return $this;
    }

    /**
     * Deletes value by `$key`.
     *
     * @param int|string $key
     * @return $this
     */
    public function delete($key): self
    {
        unset($this->haystack[$key]);

        return $this;
    }

    /**
     * Remove haystack elements by values if exists.
     *
     * @param mixed ...$values
     * @return $this
     */
    public function deleteOnFound(...$values): self
    {
        $haystack = $this->getAll();

        foreach ($values as $needle) {
            foreach ($haystack as $key => $value) {
                if ($needle === $value) {
                    $this->delete($key);
                }
            }
        }

        return $this;
    }

    /**
     * Deletes the first element.
     *
     * @return $this
     */
    public function deleteFirst(): self
    {
        $this->delete($this->getFirstKey());

        return $this;
    }

    /**
     * Deletes the last element.
     *
     * @return $this
     */
    public function deleteLast(): self
    {
        $this->delete($this->getLastKey());

        return $this;
    }

    /**
     * Deletes element by index.
     *
     * @param int $index
     * @return $this
     */
    public function deleteByIndex(int $index): self
    {
        if (!$this->inCount($index)) {
            return $this;
        }

        $i = 0;
        $haystack = ($index >= 0) ? $this->getAll() : array_reverse($this->getAll());

        foreach ($haystack as $key => $value) {
            if ($i === $index) {
                unset($this->haystack[$key]);
                break;
            }
            $i = ($index >= 0) ? $i + 1 : $i - 1;
        }

        return $this;
    }

    /**
     * Delete all values and sets empty array to haystack.
     *
     * @return $this
     */
    public function deleteAll(): self
    {
        $this->haystack = [];

        return $this;
    }

    /**
     * Flips the haystack.
     *
     * Note that it works on integer or string values. Otherwise, it will be slipped and warning be thrown
     * @return $this
     */
    public function flip(): self
    {
        $this->haystack = array_flip($this->haystack);

        return $this;
    }

    /**
     * Merges the elements of one or more arrays together.
     *
     * @param array $arrays
     * @return $this
     */
    public function merge(...$arrays): self
    {
        $this->haystack = array_merge($this->getAll(), ...$arrays);

        return $this;
    }

    /**
     * Removes duplicate values from the haystack.
     *
     * Note that it works with scalar values and PHP warning will be thrown if not.
     *
     * @param int $flags
     * @return $this
     */
    public function unique(int $flags = SORT_STRING): self
    {
        $this->haystack = array_unique($this->haystack, $flags);

        return $this;
    }

    /**
     * Sort haystack.
     *
     * @param int $flags
     * @return $this
     */
    public function sort(int $flags = SORT_REGULAR): self
    {
        sort($this->haystack, $flags);

        return $this;
    }

    /**
     * Sort haystack in reverse order.
     *
     * @param int $flags
     * @return $this
     */
    public function rsort(int $flags = SORT_REGULAR): self
    {
        rsort($this->haystack, $flags);

        return $this;
    }

    /**
     * Sort the haystack by keys.
     *
     * @param int $flags
     * @return $this
     */
    public function ksort(int $flags = SORT_REGULAR): self
    {
        ksort($this->haystack, $flags);

        return $this;
    }

    /**
     * Sort the haystack by keys in reverse order.
     *
     * @param int $flags
     * @return $this
     */
    public function krsort(int $flags = SORT_REGULAR): self
    {
        krsort($this->haystack, $flags);

        return $this;
    }

    /**
     * Sort an array and maintain index association.
     *
     * @param int $flags
     * @return $this
     */
    public function asort(int $flags = SORT_REGULAR): self
    {
        asort($this->haystack, $flags);

        return $this;
    }

    /**
     * Sort an array and maintain index association in reverse order.
     *
     * @param int $flags
     * @return $this
     */
    public function arsort(int $flags = SORT_REGULAR): self
    {
        arsort($this->haystack, $flags);

        return $this;
    }

    /**
     * Cleans real empty values in the haystack.
     *
     * @return $this
     */
    public function clean(): self
    {
        foreach ($this->getAll() as $key => $value) {
            if ($this->isEmpty($key)) {
                $this->delete($key);
            }
        }

        return $this;
    }

    /**
     * Creates collection by `key` if indexed value in the haystack is array.
     *
     * Otherwise, collection with empty haystack returns.
     *
     * @param int|string $key
     * @return $this
     */
    public function createBy($key): self
    {
        $value = (isset($this->haystack[$key]) && is_array($this->haystack[$key]))
            ? $this->haystack[$key]
            : [];

        return new static($value);
    }

    /**
     * Creates class object by first element.
     *
     * @return $this
     */
    public function createByFirst(): self
    {
        $value = $this->getFirst();

        return new static(self::getConstructArgument($value));
    }

    /**
     * Creates class object by last element.
     *
     * @return $this
     */
    public function createByLast(): self
    {
        $value = $this->getLast();

        return new static(self::getConstructArgument($value));
    }

    /**
     * Creates class object by element available by `$index`.
     *
     * @param int $index
     * @return $this
     */
    public function createByIndex(int $index): self
    {
        $value = $this->getByIndex($index);

        return new static(self::getConstructArgument($value));
    }

    /**
     * Returns tha value available for `__construct()`.
     *
     * @param mixed $value
     * @return array
     */
    private static function getConstructArgument($value): array
    {
        return (empty($value) || !is_array($value)) ? [] : $value;
    }

    /**
     * Defines if value by `$key` exists and is not empty
     *
     * @param int|string $key
     * @return bool
     */
    public function isEmpty($key): bool
    {
        if (!isset($this->haystack[$key])) {
            return true;
        }

        $value = $this->haystack[$key];

        if (!is_int($value)) {
            return (is_string($value))
                ? empty($value) || empty(trim($value))
                : empty($value);
        }

        return false;
    }

    /**
     * Defines if the given key or index exists in the haystack even nullable.
     *
     * @param int|string $key
     * @return bool
     */
    public function keyExists($key): bool
    {
        return array_key_exists($key, $this->haystack);
    }

    /**
     * Defines if all provided keys exists.
     *
     * @param int|string ...$keys
     * @return bool
     */
    public function hasKeys(...$keys): bool
    {
        foreach ($keys as $key) {
            if (!$this->keyExists($key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Defines if the haystack has any value (even nullable) indexed by keys provided.
     *
     * @param int|string ...$keys
     * @return bool
     */
    public function hasAnyKey(...$keys): bool
    {
        foreach ($keys as $key) {
            if ($this->keyExists($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Defines if all provided values exists in the haystack.
     *
     * @param mixed ...$values
     * @return bool
     */
    public function hasValues(...$values): bool
    {
        foreach ($values as $value) {
            if (!in_array($value, $this->haystack, true)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Defines if the haystack has any value provided.
     *
     * @param mixed ...$values
     * @return bool
     */
    public function hasAnyValue(...$values): bool
    {
        foreach ($this->haystack as $value) {
            if (in_array($value, $values, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Defines if the haystack length in provided value.
     *
     * @param $count
     * @return bool
     */
    public function inCount($count): bool
    {
        $length = $this->count();

        if ($count < 0) {
            $count += $length;
        }

        return $count <= $length;
    }

    /**
     * Asserts if value identically equals the value in the haystack by key.
     *
     * @param int|string $key
     * @param mixed $value
     * @return bool
     */
    public function assertEqualsByKey($key, $value): bool
    {
        return $this->get($key) === $value;
    }

    /**
     * Asserts if any value identically equals the value in the haystack by key.
     *
     * @param int|string $key
     * @param mixed ...$values
     * @return bool
     */
    public function assertAnyEqualsByKey($key, ...$values): bool
    {
        return in_array($this->get($key), $values, true);
    }
}

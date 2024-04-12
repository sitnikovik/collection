# Map

Allows you to create an array with map behavior that can store only key-value pairs.
There are several classes to choose value type that can be stored in the map.

## Usage

```php
$mixedMap = new MixedMap(); // Map with mixed values
$intMap = new IntMap(); // Map with integer values
$floatMap = new FloatMap(); // Map with float values
$stringMap = new StringMap(); // Map with string values
$boolMap = new BoolMap(); // Map with boolean values
```

## Available methods

Explain the methods available in `MixedMap`, but they are the **same** for all other classes with **different** value **types**.

### Get value
```php
get(string $key): mixed|null
```
Returns value by `$key` or `null` on not found.

### Set value
```php
set(string $key, mixed $value): void
```
Sets value by `$key`.

### Remove value
```php
remove(string $key): void
```
Removes value by `$key` on found. No throws exception on not found.

### Check value
```php
has(string $key): bool
```
Check if key exists by `$key` but not nullable.

### Get all keys
```php
keys(): array
```
Returns all keys

### Get all values
```php
values(): array
```
Returns all values without keys

### Get all pairs
```php
pairs(): array
```
Returns all pairs as associative array

### Count
```php
count(): int
```
Returns count of stored pairs

### Clear
```php
clear(): void
```
Clears all stored pairs

### Is empty
```php
isEmpty(): bool
```
Checks if map is empty




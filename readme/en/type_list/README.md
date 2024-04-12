# Type List

Array-like data structure with typed values.
There are only typed values indexed by integer keys could be stored in the list.
When you work with the list, you can be sure that all values are of the same type.

## Usage

```php
$mixedList = new MixedList(); // List with mixed values
$intList = new IntList(); // List with integer values
$floatList = new FloatList(); // List with float values
$stringList = new StringList(); // List with string values

// List with specified array and capacity
$intList = new IntList([1, 2, 3, 4, 5], 10);

// Invalid argument exception will be thrown
$intList = new IntList([1, 2, 3, 4, 5, '6']); // Invalid array
$stringList = new StringList([1, 2, 3, 4, 5], 3); // Invalid capacity
```

## Available methods

Explain the methods available in `StringList`, but they are the **same** for all other classes with **different** value **types**.

### appendValue
```php
append(string $value): self
```
Appends a value to the array and increments the length.

### get
```php
get(int $index): string
```
Returns value at the given index.
If the index is out of bounds, an exception will be thrown.

### values
```php
values(): string[]
```
Returns all the values.

### replace
```php
replace(int $index, string $value): self
```
Replaces the value at the given index.

### remove
```php
remove(int $index): self
```
Removes the value at the given index and decrements the length.
If the index is out of bounds, throws an exception.

### indexOf
```php
indexOf(string $value): ?int
```
Returns the index of the first occurrence of the given value or null if not found.

### has
```php
has(string $value): bool
```
Checks if contains the given value.

### hasAny
```php
hasAny(string ...$values): bool
```
Checks if contains any of the given values.

### hasAll
```php
hasAll(string ...$values): bool
```
Checks if contains all the given values.

### unique
```php
unique(int $flags = SORT_STRING): self
```
Makes the array unique.
Removes all null values from the array.

### sort
```php
sort(int $flags = SORT_REGULAR): self
```
Sorts the array using the given callback.

### filter
```php
filter(?callable $callback = null): self
```
Filters the array using the given callback.
If the callback is null, removes all empty values from the array.

### length
```php
length(): int
```
Returns length of the array

### capacity
```php
capacity(): int
```
Returns capacity of the array

### left
```php
left(): int
```
Returns capacity left

### isFull
```php
clear(): void
```
Checks if array is full of data

### isEmpty
```php
isEmpty(): bool
```
Checks if array is empty




# Tuple

Python-like Tuple is a immutable list storate for any type that cannot be changed after inititialized.
It has method only for get the information from tuple, not for changing.

## Usage

```php
$tupleOfntegers = IntTuple(); // Tuple of integer values
$tupleOfStrings = StringTuple(); // Tuple of string values
$tupleOfFloats = FloatTuple(); // Tuple of float values

// If you need to store any other values use:
$tupleOfMixed = MixedTuple(); 
```

## Available methods

Explain the methods available in `StringTuple`, but they are the **same** for all other classes with **different** value **types**.

### get

```php
get(int $index): ?string
```

Returns value at the given index or null on not found.

### values

```php
all(): array
```

Returns all tuple values from as array.

### count

```php
count(): int
```

Returns count of values stored in the tuple.
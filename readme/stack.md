# Stack

Implements a stack data structure LIFO (Last In First Out).

## Usage

```php
use Sitnikovik\FlexArray\Stack;

// Create a new dynamic ranged stack instance that can hold any count of items.
$stack = new Stack();

// Create a new static ranged stack instance that can hold 10 items.
$stack = new Stack(10);

// Creates a new static ranged stack with init 2 items "foo", "bar". 
// Stack has one slot available
$stack = new Stack(3, ["foo", "bar"]);
$available = $stack->available(); // 1 (3 - 2)

// throws OverflowException
$stack = new Stack(1, ["foo", "bar"]); 
```

## Methods

- [push](#push)
- [pop](#pop)
- [peek](#peek)
- [size](#size)
- [capacity](#capacity)
- [available](#available)
- [isEmpty](#isempty)
- [isFull](#isfull)

### push

Pushes item to the stack top. Throws *OverflowException* if stack is full.

```php 
push(mixed $item): void
```

### pop

Pops item from stack top. Throws *UnderflowException* onf stack is empty.

```php 
push(): mixed
```

### peek

Peeks item from stack top but not removes it. Throws *UnderflowException* onf stack is empty.

```php
peek(): mixed
```

### size

Returns current stack size

```php
size(): int
```

### capacity

Returns stack capacity

```php
capacity(): int
```

### available

Returns available stack slots. If capacity is 0 returns 0.

```php
available(): int
```

### isEmpty

Returns true if stack is empty

```php
isEmpty(): bool
```

### isFull

Returns true if stack is full of items

```php
isFull(): bool
```
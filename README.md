![PHP](https://img.shields.io/badge/PHP-%20^8.2-777BB4)
![PHPStan-Level](https://img.shields.io/badge/PHPStan-Level%209-224488)
![Pest-php](https://img.shields.io/badge/Tests-Passed-019733)
![License](https://img.shields.io/badge/License-MIT-777)

# ValueObject

A lightweight and flexible foundation for creating **Value Objects** in PHP.  
This package provides a minimalistic interface and an extensible abstract class that help developers build semantic value objects that encourage immutability, with optional validation and a clean factory pattern.


## ✨ Features

- **Named constructors**: Each value object defines its own typed factory methods (e.g. `fromString()`, `fromParts()`), ensuring full type safety and IDE support.

- **Immutability**: Uses `readonly` properties (PHP 8.2+) to ensure value objects cannot be modified after creation.

- **Optional validation**: `isValid()`  
  Developers decide when and how to validate the underlying value.

- **Semantic comparison**: `equals(ValueObjectInterface $other)`  
  Compares via `toArray()` representation, ensuring structural equality with type safety.

- **Consistent value access**: `value()`  
  Returns the underlying primitive or structured value.

- **Hash support**: `hashCode()`  
  Deterministic hash based on `toArray()` for use as array keys or in collections.

- **Universal serialization**: `toArray()`  
  Returns array representation, works with JSON, XML, and other formats.

- **Change detection**: `diff(ValueObjectInterface $other)`  
  Shows what changed between two value objects.

- **String representation**: `toString()` and `__toString()`  
  Ensures every value object can be safely cast to a string.

- **Minimalistic and extensible**  
  The interface stays small and expressive, while concrete classes define their own semantics and factories.

---

## 🔍 How Comparisons Work

Both `equals()` and `diff()` compare value objects using their `toArray()` representation.

This approach ensures:
- **Full structural equality**: Not just raw value, but the complete semantic representation
- **Type safety**: `equals()` requires same class via `instanceof static`
- **Consistent behavior**: Hash, JSON, XML, and comparisons all use the same array structure

```php
$email1 = Email::fromString('user@example.com');
$email2 = Email::fromString('USER@EXAMPLE.COM');

// Both normalize to the same toArray() representation
$email1->toArray(); // ['email' => 'user@example.com', 'user' => 'user', 'domain' => 'example.com']
$email2->toArray(); // ['email' => 'user@example.com', 'user' => 'user', 'domain' => 'example.com']

$email1->equals($email2); // true
```

The `hashCode()` method also uses `toArray()`, ensuring consistency when value objects are used as array keys or in collections.

---

## 📦 Installation

Install via Composer:

```bash
composer require stougeiro/valueobject
```


## 🚀 Usage

### Defining a Value Object

```php
use STDW\ValueObject\ValueObjectAbstracted;

final class Email extends ValueObjectAbstracted
{
    private function __construct(private readonly string $email) {}

    public static function fromString(string $email): static
    {
        $instance = new self(strtolower(trim($email)));

        if ( ! $instance->isValid()) {
            throw new \InvalidArgumentException("Invalid email: {$email}");
        }

        return $instance;
    }

    public function value(): string
    {
        return $this->email;
    }

    public function isValid(): bool
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function user(): string
    {
        return explode('@', $this->email)[0];
    }

    public function domain(): string
    {
        return explode('@', $this->email)[1];
    }

    public function toString(): string
    {
        return $this->email;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'user' => $this->user(),
            'domain' => $this->domain(),
        ];
    }
}
```

### Creating Instances

Named constructors are defined by you, with full type safety:

```php
$email = Email::fromString('User@Example.com');

$email->value();              // "user@example.com"
$email->toString();           // "user@example.com"
(string) $email;              // "user@example.com"
```

### Comparison

```php
$other = Email::fromString('user@example.com');

$email->equals($other);       // true (same structure)
$email->equals($other);       // true (normalization applied)
```

### Serialization

```php
// Array
$email->toArray();
// ['email' => 'user@example.com', 'user' => 'user', 'domain' => 'example.com']

// JSON
json_encode($email->toArray());
// '{"email":"user@example.com","user":"user","domain":"example.com"}'

// As array key
$emails = [$email->hashCode() => $email];
```

### Change Detection

```php
$current = Email::fromString('user@example.com');
$updated = Email::fromString('new@domain.com');

$current->diff($updated);
// ['email' => 'new@domain.com', 'user' => 'new', 'domain' => 'domain.com']

// Empty when no changes
$current->diff(Email::fromString('user@example.com'));
// []
```

### Domain-Specific Accessors

Define your own semantic methods:

```php
$email = Email::fromString('user@example.com');

$email->user();               // "user"
$email->domain();             // "example.com"
```

---

## 🧠 Why Value Objects?

Value Objects are a core building block in domain‑driven design and clean architecture. They encapsulate meaning, enforce structure, and prevent primitive obsession — ensuring that values carry behavior and validation instead of floating loosely through the system.

This package aims to provide a simple, expressive and unobtrusive foundation for building your own Value Objects without unnecessary boilerplate.

---

## 🤝 Contributions

Contributions are welcome.
Feel free to open issues or submit pull requests.

<br>

[<img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" width="170"/>](https://www.buymeacoffee.com/stougeiro)
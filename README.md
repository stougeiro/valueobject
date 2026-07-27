# ValueObject

A lightweight and flexible foundation for creating **Value Objects** in PHP.  
This package provides a minimalistic interface and an extensible abstract class that help developers build semantic value objects that encourage immutability, with optional validation and a clean factory pattern.

---

## ✨ Features

- **Generic factory**: `create(...$args)`  
  Delegates construction to the concrete class while respecting its parameter types and order.

- **Optional validation**: `isValid()`  
  Developers decide when and how to validate the underlying value.

- **Semantic comparison**: `equals(ValueObjectInterface $other)`  
  Compare two value objects of the same type and value.

- **Consistent value access**: `value()`  
  Returns the underlying primitive or structured value.

- **String representation**: `__toString()`  
  Ensures every value object can be safely cast to a string.

- **Minimalistic and extensible**  
  The interface stays small and expressive, while concrete classes define their own semantics.


## 📦 Installation

Install via Composer:

```bash
composer require stougeiro/valueobject
```


## 🚀 Usage Example

### Creating a Value Object

```php
use STDW\ValueObject\ValueObjectAbstracted;

final class Email extends ValueObjectAbstracted
{
    public function __construct(private string $email) {}

    public function value(): mixed
    {
        return $this->email;
    }

    public function isValid(): bool
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function __toString__(): string
    {
        return $this->email;
    }
}
```


## 🚀 Instantiation

```php
    $email = Email::create('sidney@example.com');

    if ($email->isValid()) {
        echo $email; // sidney@example.com
    }
```

---

## 🧠 Why Value Objects?

Value Objects are a core building block in domain‑driven design and clean architecture. They encapsulate meaning, enforce structure, and prevent primitive obsession — ensuring that values carry behavior and validation instead of floating loosely through the system.

This package aims to provide a simple, expressive and unobtrusive foundation for building your own Value Objects without unnecessary boilerplate.
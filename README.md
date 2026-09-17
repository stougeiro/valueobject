![PHP](https://img.shields.io/badge/PHP-%20^8.2-777BB4)
![PHPStan-Level](https://img.shields.io/badge/PHPStan-Level%209-224488)
![Pest-php](https://img.shields.io/badge/Tests-Passed-019733)
![License](https://img.shields.io/badge/License-MIT-777)

# ValueObject

A lightweight and flexible foundation for creating **Value Objects** in PHP.  
This package provides a minimalistic interface and an extensible abstract class that help developers build semantic value objects that encourage immutability, with optional validation and a clean factory pattern.


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

---

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

    public function __toString(): string
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

---

## 🤝 Contributions

Contributions are welcome.
Feel free to open issues or submit pull requests.

<br>

[<img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" width="170"/>](https://www.buymeacoffee.com/stougeiro)
<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use STDW\ValueObject\ValueObjectAbstracted;

final class NonSerializableVO extends ValueObjectAbstracted
{
    private function __construct(
        private readonly mixed $value,
    ) {}

    public static function fromCallable(callable $callback): static
    {
        return new self($callback);
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function isValid(): bool
    {
        return true;
    }

    public function toString(): string
    {
        return 'non-serializable';
    }

    public function toArray(): array
    {
        return ['value' => 'non-serializable'];
    }
}

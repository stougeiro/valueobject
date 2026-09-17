<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use STDW\ValueObject\ValueObjectAbstracted;

final class Address extends ValueObjectAbstracted
{
    private function __construct(
        private readonly string $street,
        private readonly string $city,
        private readonly string $country,
        private readonly string $zipCode,
        private readonly ?string $state = null,
    ) {}

    public static function create(
        string $street,
        string $city,
        string $country,
        string $zipCode,
        ?string $state = null,
    ): static {
        $instance = new self(
            trim($street),
            trim($city),
            strtoupper(trim($country)),
            trim($zipCode),
            $state !== null ? trim($state) : null,
        );

        if ( ! $instance->isValid()) {
            throw new \InvalidArgumentException('Street and city are required');
        }

        return $instance;
    }

    public function value(): array
    {
        return $this->toArray();
    }

    public function isValid(): bool
    {
        return $this->street !== '' && $this->city !== '';
    }

    public function street(): string
    {
        return $this->street;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function zipCode(): string
    {
        return $this->zipCode;
    }

    public function state(): ?string
    {
        return $this->state;
    }

    public function toString(): string
    {
        $parts = [$this->street, $this->city];

        if ($this->state !== null) {
            $parts[] = $this->state;
        }

        $parts[] = $this->country;
        $parts[] = $this->zipCode;

        return implode(', ', $parts);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'street' => $this->street,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'zipCode' => $this->zipCode,
        ], fn($v) => $v !== null);
    }
}

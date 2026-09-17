<?php

    namespace Tests\Fixtures;

    use STDW\ValueObject\ValueObjectAbstracted;

    final class Email extends ValueObjectAbstracted
    {
        private function __construct(
            private readonly string $email,
        ) {}

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

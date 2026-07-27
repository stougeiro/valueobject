<?php declare(strict_types=1);

    namespace STDW\ValueObject;

    use Stringable;


    interface ValueObjectInterface extends Stringable
    {
        public static function create(mixed ...$args): ValueObjectInterface;


        public function value(): mixed;

        public function equals(ValueObjectInterface $other): bool;

        public function isValid(): bool;

        public function __toString(): string;
    }

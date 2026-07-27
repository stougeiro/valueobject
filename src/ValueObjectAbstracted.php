<?php declare(strict_types=1);

    namespace STDW\ValueObject;


    abstract class ValueObjectAbstracted implements ValueObjectInterface
    {
        public static function create(mixed ...$args): ValueObjectInterface
        {
            return new static(...$args);
        }


        abstract public function value(): mixed;

        public function equals(ValueObjectInterface $other): bool
        {
            return $other instanceof static
                && $other->value() === $this->value();
        }

        abstract public function isValid(): bool;

        abstract public function __toString(): string;
    }

<?php declare(strict_types=1);

    namespace STDW\ValueObject;


    abstract class ValueObjectAbstracted implements ValueObjectInterface
    {
        /**
         * @return ValueObjectInterface
         */
        abstract public static function create(mixed ...$args): ValueObjectInterface;

        /**
         * @return mixed
         */
        abstract public function value(): mixed;

        /**
         * @param ValueObjectInterface $other
         * @return bool
         */
        public function equals(ValueObjectInterface $other): bool
        {
            return $other instanceof static
                && $other->value() === $this->value();
        }

        /**
         * @return bool
         */
        abstract public function isValid(): bool;

        /**
         * @return string
         */
        abstract public function __toString(): string;
    }

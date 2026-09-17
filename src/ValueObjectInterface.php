<?php declare(strict_types=1);

    namespace STDW\ValueObject;

    use Stringable;


    interface ValueObjectInterface extends Stringable
    {
        /** @return mixed 
         */
        public function value(): mixed;

        /** @return string 
         */
        public function hashCode(): string;

        /** @return bool 
         */
        public function isValid(): bool;

        /** @return string 
         */
        public function toString(): string;

        /** @return array<string, mixed>
        */
        public function toArray(): array;

        /**
         * @param ValueObjectInterface $other 
         * @return bool 
         */
        public function equals(ValueObjectInterface $other): bool;

        /**
         * @param ValueObjectInterface $other 
         * @return array<string, mixed> 
         */
        public function diff(ValueObjectInterface $other): array;

        /** @return string 
         */
        public function __toString(): string;
    }

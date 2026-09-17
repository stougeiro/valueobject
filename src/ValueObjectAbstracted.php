<?php declare(strict_types=1);

    namespace STDW\ValueObject;


    abstract class ValueObjectAbstracted implements ValueObjectInterface
    {
        /** @return mixed 
         */
        public abstract function value(): mixed;

        /** @return string 
         */
        public function hashCode(): string
        {
            return $this->hash($this->toArray());
        }

        /** @return bool 
         */
        public abstract function isValid(): bool;

        /** @return string 
         */
        public abstract function toString(): string;

        /** @return array<string, mixed>
         */
        public abstract function toArray(): array;

        /**
         * @param ValueObjectInterface $other 
         * @return bool 
         */
        public function equals(ValueObjectInterface $other): bool
        {
            return $other instanceof static
                && $this->hash($this->toArray()) === $this->hash($other->toArray());
        }

        /**
         * @param ValueObjectInterface $other 
         * @return array<string, mixed> 
         */
        public function diff(ValueObjectInterface $other): array
        {
            $current = $this->toArray();
            $compare = $other->toArray();
            $changes = [];

            foreach ($compare as $key => $value) {
                if ( ! isset($current[$key]) || $current[$key] !== $value) {
                    $changes[$key] = $value;
                }
            }

            return $changes;
        }

        /** @return string 
         */
        public function __toString(): string
        {
            return $this->toString();
        }


        /**
         * @param array<string, mixed> $value 
         * @return string 
         */
        protected function hash(array $value): string
        {
            return sha1(serialize($value));
        }
    }

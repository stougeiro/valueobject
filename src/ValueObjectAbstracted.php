<?php declare(strict_types=1);

    namespace STDW\ValueObject;


    abstract class ValueObjectAbstracted implements ValueObjectInterface
    {
        public static function create(...$args): ValueObjectInterface
        {
            return new static(...$args);
        }


        abstract public function get(): mixed;

        abstract public function isValid(): bool;

        abstract public function __toString(): string;
    }

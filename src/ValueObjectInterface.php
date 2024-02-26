<?php declare(strict_types=1);

    namespace STDW\ValueObject;


    interface ValueObjectInterface
    {
        public static function create(...$args): ValueObjectInterface;

        public function get(): mixed;

        public function isValid(): bool;

        public function __toString(): string;
    }
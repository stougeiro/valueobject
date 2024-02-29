<?php declare(strict_types=1);

    namespace STDW\ValueObject;

    use Stringable;


    interface ValueObjectInterface extends Stringable
    {
        public static function create(...$args): ValueObjectInterface;

        public function get(): mixed;

        public function isValid(): bool;

        public function __toString(): string;
    }
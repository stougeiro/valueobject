<?php

use Tests\Fixtures\Address;

it('can create address with all fields', function () {
    $address = Address::create('Rua 1', 'São Paulo', 'br', '01234-567', 'SP');

    expect($address->street())->toBe('Rua 1')
        ->and($address->city())->toBe('São Paulo')
        ->and($address->country())->toBe('BR')
        ->and($address->zipCode())->toBe('01234-567')
        ->and($address->state())->toBe('SP');
});

it('can create address without state', function () {
    $address = Address::create('Rua 1', 'São Paulo', 'br', '01234-567');

    expect($address->state())->toBeNull();
});

it('normalizes country to uppercase', function () {
    $address = Address::create('Rua 1', 'São Paulo', 'br', '01234-567');

    expect($address->country())->toBe('BR');
});

it('trims whitespace from all fields', function () {
    $address = Address::create('  Rua 1  ', '  São Paulo  ', '  br  ', '  01234-567  ');

    expect($address->street())->toBe('Rua 1')
        ->and($address->city())->toBe('São Paulo')
        ->and($address->zipCode())->toBe('01234-567');
});

it('toArray returns all fields', function () {
    $address = Address::create('Rua 1', 'São Paulo', 'br', '01234-567', 'SP');

    expect($address->toArray())->toBe([
        'street' => 'Rua 1',
        'city' => 'São Paulo',
        'state' => 'SP',
        'country' => 'BR',
        'zipCode' => '01234-567',
    ]);
});

it('toArray excludes null state', function () {
    $address = Address::create('Rua 1', 'São Paulo', 'br', '01234-567');

    expect($address->toArray())->toBe([
        'street' => 'Rua 1',
        'city' => 'São Paulo',
        'country' => 'BR',
        'zipCode' => '01234-567',
    ])->and(array_keys($address->toArray()))->not->toContain('state');
});

it('toString includes state when present', function () {
    $address = Address::create('Rua 1', 'São Paulo', 'br', '01234-567', 'SP');

    expect($address->toString())->toBe('Rua 1, São Paulo, SP, BR, 01234-567');
});

it('toString excludes state when null', function () {
    $address = Address::create('Rua 1', 'São Paulo', 'br', '01234-567');

    expect($address->toString())->toBe('Rua 1, São Paulo, BR, 01234-567');
});

it('equals returns true for same values', function () {
    $address1 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567', 'SP');
    $address2 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567', 'SP');

    expect($address1->equals($address2))->toBeTrue();
});

it('equals returns false for different city', function () {
    $address1 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567');
    $address2 = Address::create('Rua 1', 'Rio de Janeiro', 'br', '01234-567');

    expect($address1->equals($address2))->toBeFalse();
});

it('diff returns only changed fields', function () {
    $address1 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567');
    $address2 = Address::create('Rua 1', 'Rio de Janeiro', 'br', '01234-567');

    $diff = $address1->diff($address2);

    expect($diff)->toBe(['city' => 'Rio de Janeiro'])
        ->and(array_keys($diff))->toHaveLength(1);
});

it('diff returns multiple changed fields', function () {
    $address1 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567');
    $address2 = Address::create('Rua 2', 'Rio de Janeiro', 'br', '76543-210');

    $diff = $address1->diff($address2);

    expect($diff)->toHaveKeys(['street', 'city', 'zipCode'])
        ->and(array_keys($diff))->toHaveLength(3);
});

it('diff returns empty array for same values', function () {
    $address1 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567', 'SP');
    $address2 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567', 'SP');

    expect($address1->diff($address2))->toBe([]);
});

it('diff handles null to value transition', function () {
    $address1 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567');
    $address2 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567', 'SP');

    $diff = $address1->diff($address2);

    expect($diff)->toBe(['state' => 'SP']);
});

it('diff handles value to null transition', function () {
    $address1 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567', 'SP');
    $address2 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567');

    $diff = $address1->diff($address2);

    expect($diff)->toBe([]);
});

it('hashCode is consistent for same values', function () {
    $address1 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567', 'SP');
    $address2 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567', 'SP');

    expect($address1->hashCode())->toBe($address2->hashCode());
});

it('hashCode differs with nullable field', function () {
    $address1 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567');
    $address2 = Address::create('Rua 1', 'São Paulo', 'br', '01234-567', 'SP');

    expect($address1->hashCode())->not->toBe($address2->hashCode());
});

it('hashCode returns valid sha1 hash', function () {
    $address = Address::create('Rua 1', 'São Paulo', 'br', '01234-567');

    expect($address->hashCode())->toHaveLength(40)
        ->and($address->hashCode())->toMatch('/^[a-f0-9]+$/');
});

it('address is immutable', function () {
    $address = Address::create('Rua 1', 'São Paulo', 'br', '01234-567');
    $reflection = new ReflectionClass($address);

    foreach ($reflection->getProperties() as $property) {
        expect($property->isReadOnly())->toBeTrue();
    }
});

it('rejects empty street', function () {
    Address::create('', 'São Paulo', 'br', '01234-567');
})->throws(\InvalidArgumentException::class);

it('rejects empty city', function () {
    Address::create('Rua 1', '', 'br', '01234-567');
})->throws(\InvalidArgumentException::class);

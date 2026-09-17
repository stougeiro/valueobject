<?php

it('value returns the underlying value', function () {
    $email = makeEmail('user@example.com');

    expect($email->value())->toBe('user@example.com');
});

it('equals returns true for same value', function () {
    $email1 = makeEmail('user@example.com');
    $email2 = makeEmail('user@example.com');

    expect($email1->equals($email2))->toBeTrue();
});

it('equals returns false for different value', function () {
    $email1 = makeEmail('user@example.com');
    $email2 = makeEmail('other@example.com');

    expect($email1->equals($email2))->toBeFalse();
});

it('equals returns false for different VO types', function () {
    $email = makeEmail('user@example.com');
    $address = \Tests\Fixtures\Address::create('Rua 1', 'São Paulo', 'br', '01234-567');

    expect($email->equals($address))->toBeFalse();
});

it('hashCode returns consistent hash', function () {
    $email1 = makeEmail('user@example.com');
    $email2 = makeEmail('user@example.com');

    expect($email1->hashCode())->toBe($email2->hashCode());
});

it('hashCode returns different hash for different values', function () {
    $email1 = makeEmail('user@example.com');
    $email2 = makeEmail('other@example.com');

    expect($email1->hashCode())->not->toBe($email2->hashCode());
});

it('hashCode returns valid sha1 hash', function () {
    $email = makeEmail('user@example.com');
    $hash = $email->hashCode();

    expect($hash)->toHaveLength(40)
        ->and($hash)->toMatch('/^[a-f0-9]+$/');
});

it('toArray returns structured array', function () {
    $email = makeEmail('user@example.com');

    expect($email->toArray())->toBe([
        'email' => 'user@example.com',
        'user' => 'user',
        'domain' => 'example.com',
    ]);
});

it('diff returns empty array for same values', function () {
    $email1 = makeEmail('user@example.com');
    $email2 = makeEmail('user@example.com');

    expect($email1->diff($email2))->toBe([]);
});

it('diff returns changed fields', function () {
    $email1 = makeEmail('user@example.com');
    $email2 = makeEmail('new@domain.com');

    $diff = $email1->diff($email2);

    expect($diff)->toHaveKeys(['email', 'user', 'domain']);
});

it('diff returns only changed fields', function () {
    $email1 = makeEmail('user@example.com');
    $email2 = makeEmail('user@domain.com');

    $diff = $email1->diff($email2);

    expect(array_keys($diff))->toHaveLength(2)
        ->and($diff)->toHaveKeys(['email', 'domain']);
});

it('diff returns only changed field for multi-property VO', function () {
    $address1 = \Tests\Fixtures\Address::create('Rua 1', 'São Paulo', 'br', '01234-567');
    $address2 = \Tests\Fixtures\Address::create('Rua 1', 'Rio de Janeiro', 'br', '01234-567');

    $diff = $address1->diff($address2);

    expect(array_keys($diff))->toHaveLength(1)
        ->and($diff['city'])->toBe('Rio de Janeiro');
});

it('diff returns multiple changed fields', function () {
    $address1 = \Tests\Fixtures\Address::create('Rua 1', 'São Paulo', 'br', '01234-567');
    $address2 = \Tests\Fixtures\Address::create('Rua 2', 'Rio de Janeiro', 'br', '76543-210');

    $diff = $address1->diff($address2);

    expect(array_keys($diff))->toHaveLength(3)
        ->and($diff)->toHaveKeys(['street', 'city', 'zipCode']);
});

it('toString returns string representation', function () {
    $email = makeEmail('user@example.com');

    expect($email->toString())->toBe('user@example.com');
});

it('__toString returns string representation', function () {
    $email = makeEmail('user@example.com');

    expect((string) $email)->toBe('user@example.com');
});

it('toString and __toString return same value', function () {
    $email = makeEmail('user@example.com');

    expect($email->toString())->toBe((string) $email);
});

it('value object is immutable', function () {
    $email = makeEmail('user@example.com');
    $reflection = new ReflectionClass($email);

    foreach ($reflection->getProperties() as $property) {
        expect($property->isReadOnly())->toBeTrue();
    }
});

it('hashCode works with non-serializable value', function () {
    $vo = \Tests\Fixtures\NonSerializableVO::fromCallable(fn() => 'test');

    expect($vo->hashCode())->toHaveLength(40)
        ->and($vo->hashCode())->toMatch('/^[a-f0-9]+$/');
});

it('rejects invalid emails', function (string $email) {
    makeEmail($email);
})->throws(\InvalidArgumentException::class)->with([
    '' => '',
    'invalid-email' => 'invalid-email',
    'no domain' => 'user@',
    'no user' => '@example.com',
]);

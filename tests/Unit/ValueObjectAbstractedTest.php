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

it('hashCode returns sha1 hash', function () {
    $email = makeEmail('user@example.com');
    $hash = $email->hashCode();

    expect($hash)->toHaveLength(40)
        ->and($hash)->toMatch('/^[a-f0-9]+$/');
});

it('toArray returns array with value', function () {
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

it('diff returns changes for different values', function () {
    $email1 = makeEmail('user@example.com');
    $email2 = makeEmail('new@domain.com');

    $diff = $email1->diff($email2);

    expect($diff)->toBe([
        'email' => 'new@domain.com',
        'user' => 'new',
        'domain' => 'domain.com',
    ]);
});

it('diff returns only changed fields', function () {
    $email1 = makeEmail('user@example.com');
    $email2 = makeEmail('user@domain.com');

    $diff = $email1->diff($email2);

    expect($diff)->toBe([
        'email' => 'user@domain.com',
        'domain' => 'domain.com',
    ]);
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
    $properties = $reflection->getProperties();

    foreach ($properties as $property) {
        expect($property->isReadOnly())->toBeTrue();
    }
});

it('email is normalized to lowercase', function () {
    $email = makeEmail('User@Example.COM');

    expect($email->value())->toBe('user@example.com');
});

it('email is trimmed', function () {
    $email = makeEmail('  user@example.com  ');

    expect($email->value())->toBe('user@example.com');
});

it('invalid email throws exception', function () {
    makeEmail('invalid-email');
})->throws(\InvalidArgumentException::class);

it('empty email throws exception', function () {
    makeEmail('');
})->throws(\InvalidArgumentException::class);

it('email without domain throws exception', function () {
    makeEmail('user@');
})->throws(\InvalidArgumentException::class);

it('email without user throws exception', function () {
    makeEmail('@example.com');
})->throws(\InvalidArgumentException::class);

<?php

use Tests\Fixtures\Email;

it('can create email from string', function () {
    $email = Email::fromString('user@example.com');

    expect($email)->toBeInstanceOf(Email::class)
        ->and($email->value())->toBe('user@example.com');
});

it('email is normalized to lowercase', function () {
    $email = Email::fromString('USER@EXAMPLE.COM');

    expect($email->value())->toBe('user@example.com');
});

it('email is trimmed', function () {
    $email = Email::fromString('  user@example.com  ');

    expect($email->value())->toBe('user@example.com');
});

it('email user() returns local part', function () {
    $email = Email::fromString('user@example.com');

    expect($email->user())->toBe('user');
});

it('email domain() returns domain part', function () {
    $email = Email::fromString('user@example.com');

    expect($email->domain())->toBe('example.com');
});

it('email can be cast to string', function () {
    $email = Email::fromString('user@example.com');

    expect((string) $email)->toBe('user@example.com');
});

it('email toString() returns email', function () {
    $email = Email::fromString('user@example.com');

    expect($email->toString())->toBe('user@example.com');
});

it('email toArray() returns structured data', function () {
    $email = Email::fromString('user@example.com');

    expect($email->toArray())->toBe([
        'email' => 'user@example.com',
        'user' => 'user',
        'domain' => 'example.com',
    ]);
});

it('two emails with same value are equal', function () {
    $email1 = Email::fromString('user@example.com');
    $email2 = Email::fromString('user@example.com');

    expect($email1->equals($email2))->toBeTrue();
});

it('two emails with different values are not equal', function () {
    $email1 = Email::fromString('user@example.com');
    $email2 = Email::fromString('other@example.com');

    expect($email1->equals($email2))->toBeFalse();
});

it('email diff shows changes', function () {
    $email1 = Email::fromString('user@example.com');
    $email2 = Email::fromString('new@domain.com');

    $diff = $email1->diff($email2);

    expect($diff)->toHaveKeys(['email', 'user', 'domain'])
        ->and($diff['email'])->toBe('new@domain.com')
        ->and($diff['user'])->toBe('new')
        ->and($diff['domain'])->toBe('domain.com');
});

it('email diff returns empty for same email', function () {
    $email1 = Email::fromString('user@example.com');
    $email2 = Email::fromString('user@example.com');

    expect($email1->diff($email2))->toBe([]);
});

it('email hashCode is consistent', function () {
    $email1 = Email::fromString('user@example.com');
    $email2 = Email::fromString('user@example.com');

    expect($email1->hashCode())->toBe($email2->hashCode());
});

it('email can be used as array key', function () {
    $email = Email::fromString('user@example.com');
    $emails = [$email->hashCode() => $email];

    expect($emails)->toHaveKey($email->hashCode())
        ->and($emails[$email->hashCode()])->toBe($email);
});

it('email is immutable', function () {
    $email = Email::fromString('user@example.com');
    $reflection = new ReflectionClass($email);
    $property = $reflection->getProperty('email');

    expect($property->isReadOnly())->toBeTrue();
});

it('rejects invalid emails', function (string $email) {
    Email::fromString($email);
})->throws(\InvalidArgumentException::class)->with([
    'invalid-email',
    'user@name@example.com',
]);

<?php

use Tests\Fixtures\Email;

it('email creation performance', function () {
    $iterations = 10000;
    $start = microtime(true);

    for ($i = 0; $i < $iterations; $i++) {
        Email::fromString("user{$i}@example.com");
    }

    $elapsed = microtime(true) - $start;
    $perSecond = $iterations / $elapsed;

    expect($elapsed)->toBeLessThan(2.0)
        ->and($perSecond)->toBeGreaterThan(5000);
});

it('email value() performance', function () {
    $email = Email::fromString('user@example.com');
    $iterations = 100000;
    $start = microtime(true);

    for ($i = 0; $i < $iterations; $i++) {
        $email->value();
    }

    $elapsed = microtime(true) - $start;
    $perSecond = $iterations / $elapsed;

    expect($elapsed)->toBeLessThan(1.0)
        ->and($perSecond)->toBeGreaterThan(50000);
});

it('email equals() performance', function () {
    $email1 = Email::fromString('user@example.com');
    $email2 = Email::fromString('user@example.com');
    $iterations = 100000;
    $start = microtime(true);

    for ($i = 0; $i < $iterations; $i++) {
        $email1->equals($email2);
    }

    $elapsed = microtime(true) - $start;
    $perSecond = $iterations / $elapsed;

    expect($elapsed)->toBeLessThan(2.0)
        ->and($perSecond)->toBeGreaterThan(50000);
});

it('email hashCode() performance', function () {
    $email = Email::fromString('user@example.com');
    $iterations = 100000;
    $start = microtime(true);

    for ($i = 0; $i < $iterations; $i++) {
        $email->hashCode();
    }

    $elapsed = microtime(true) - $start;
    $perSecond = $iterations / $elapsed;

    expect($elapsed)->toBeLessThan(2.0)
        ->and($perSecond)->toBeGreaterThan(50000);
});

it('email toArray() performance', function () {
    $email = Email::fromString('user@example.com');
    $iterations = 100000;
    $start = microtime(true);

    for ($i = 0; $i < $iterations; $i++) {
        $email->toArray();
    }

    $elapsed = microtime(true) - $start;
    $perSecond = $iterations / $elapsed;

    expect($elapsed)->toBeLessThan(1.0)
        ->and($perSecond)->toBeGreaterThan(50000);
});

it('email diff() performance', function () {
    $email1 = Email::fromString('user@example.com');
    $email2 = Email::fromString('new@domain.com');
    $iterations = 100000;
    $start = microtime(true);

    for ($i = 0; $i < $iterations; $i++) {
        $email1->diff($email2);
    }

    $elapsed = microtime(true) - $start;
    $perSecond = $iterations / $elapsed;

    expect($elapsed)->toBeLessThan(2.0)
        ->and($perSecond)->toBeGreaterThan(50000);
});

it('email toString() performance', function () {
    $email = Email::fromString('user@example.com');
    $iterations = 100000;
    $start = microtime(true);

    for ($i = 0; $i < $iterations; $i++) {
        $email->toString();
    }

    $elapsed = microtime(true) - $start;
    $perSecond = $iterations / $elapsed;

    expect($elapsed)->toBeLessThan(1.0)
        ->and($perSecond)->toBeGreaterThan(50000);
});

it('email collection performance', function () {
    $emails = [];
    for ($i = 0; $i < 1000; $i++) {
        $emails[] = Email::fromString("user{$i}@example.com");
    }

    $iterations = 1000;
    $start = microtime(true);

    for ($i = 0; $i < $iterations; $i++) {
        $email = $emails[$i % 1000];
        $hash = $email->hashCode();
    }

    $elapsed = microtime(true) - $start;
    $perSecond = $iterations / $elapsed;

    expect($elapsed)->toBeLessThan(1.0)
        ->and($perSecond)->toBeGreaterThan(5000);
});

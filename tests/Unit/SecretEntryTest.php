<?php

declare(strict_types=1);

use Accelade\Infolists\Components\SecretEntry;

it('can create a secret entry', function () {
    $entry = SecretEntry::make('password');

    expect($entry->getName())->toBe('password');
});

it('has default mask', function () {
    $entry = SecretEntry::make('password');

    expect($entry->getMask())->toBe('********');
});

it('can set custom mask', function () {
    $entry = SecretEntry::make('password')
        ->mask('••••••');

    expect($entry->getMask())->toBe('••••••');
});

it('has no visible characters by default', function () {
    $entry = SecretEntry::make('password');

    expect($entry->getVisibleCharacters())->toBeNull();
});

it('can show last characters', function () {
    $entry = SecretEntry::make('password')
        ->showLast(4);

    expect($entry->getVisibleCharacters())->toBe(4);
    expect($entry->getVisiblePosition())->toBe('end');
});

it('can show first characters', function () {
    $entry = SecretEntry::make('password')
        ->showFirst(4);

    expect($entry->getVisibleCharacters())->toBe(4);
    expect($entry->getVisiblePosition())->toBe('start');
});

it('reveals on click by default', function () {
    $entry = SecretEntry::make('password');

    expect($entry->isRevealOnClick())->toBeTrue();
});

it('does not reveal on hover by default', function () {
    $entry = SecretEntry::make('password');

    expect($entry->isRevealOnHover())->toBeFalse();
});

it('can reveal on hover', function () {
    $entry = SecretEntry::make('password')
        ->revealOnHover();

    expect($entry->isRevealOnHover())->toBeTrue();
});

it('can disable reveal on click', function () {
    $entry = SecretEntry::make('password')
        ->revealOnClick(false);

    expect($entry->isRevealOnClick())->toBeFalse();
});

it('has default reveal icon', function () {
    $entry = SecretEntry::make('password');

    expect($entry->getRevealIcon())->toBe('heroicon-o-eye');
});

it('has default hide icon', function () {
    $entry = SecretEntry::make('password');

    expect($entry->getHideIcon())->toBe('heroicon-o-eye-slash');
});

it('can set custom reveal icon', function () {
    $entry = SecretEntry::make('password')
        ->revealIcon('heroicon-o-lock-open');

    expect($entry->getRevealIcon())->toBe('heroicon-o-lock-open');
});

it('can set custom hide icon', function () {
    $entry = SecretEntry::make('password')
        ->hideIcon('heroicon-o-lock-closed');

    expect($entry->getHideIcon())->toBe('heroicon-o-lock-closed');
});

it('has no auto hide by default', function () {
    $entry = SecretEntry::make('password');

    expect($entry->getAutoHideAfter())->toBeNull();
});

it('can set auto hide after seconds', function () {
    $entry = SecretEntry::make('password')
        ->autoHideAfter(5);

    expect($entry->getAutoHideAfter())->toBe(5);
});

it('returns masked value with default mask', function () {
    $entry = SecretEntry::make('password')
        ->record(['password' => 'secret123']);

    expect($entry->getMaskedValue())->toBe('********');
});

it('returns masked value with visible last characters', function () {
    $entry = SecretEntry::make('password')
        ->showLast(4)
        ->record(['password' => 'secret123']);

    expect($entry->getMaskedValue())->toBe('********t123');
});

it('returns masked value with visible first characters', function () {
    $entry = SecretEntry::make('password')
        ->showFirst(4)
        ->record(['password' => 'secret123']);

    expect($entry->getMaskedValue())->toBe('secr********');
});

it('returns mask for null value', function () {
    $entry = SecretEntry::make('password')
        ->record([]);

    expect($entry->getMaskedValue())->toBe('********');
});

it('returns mask for empty value', function () {
    $entry = SecretEntry::make('password')
        ->record(['password' => '']);

    expect($entry->getMaskedValue())->toBe('********');
});

it('gets actual value', function () {
    $entry = SecretEntry::make('password')
        ->record(['password' => 'secret123']);

    expect($entry->getActualValue())->toBe('secret123');
});

it('returns null for null actual value', function () {
    $entry = SecretEntry::make('password')
        ->record([]);

    expect($entry->getActualValue())->toBeNull();
});

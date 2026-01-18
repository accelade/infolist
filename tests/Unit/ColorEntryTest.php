<?php

declare(strict_types=1);

use Accelade\Infolists\Components\ColorEntry;

it('can create a color entry', function () {
    $entry = ColorEntry::make('primary_color');

    expect($entry->getName())->toBe('primary_color');
});

it('can get state from record', function () {
    $entry = ColorEntry::make('primary_color')
        ->record(['primary_color' => '#3B82F6']);

    expect($entry->getState())->toBe('#3B82F6');
});

it('can be copyable', function () {
    $entry = ColorEntry::make('primary_color')
        ->copyable();

    expect($entry->isCopyable())->toBeTrue();
});

it('can set custom copy message', function () {
    $entry = ColorEntry::make('primary_color')
        ->copyable()
        ->copyMessage('Color copied!');

    expect($entry->getCopyMessage())->toBe('Color copied!');
});

it('can set copy message duration', function () {
    $entry = ColorEntry::make('primary_color')
        ->copyable()
        ->copyMessageDuration(3000);

    expect($entry->getCopyMessageDuration())->toBe(3000);
});

it('can set tooltip', function () {
    $entry = ColorEntry::make('primary_color')
        ->tooltip('Primary brand color');

    expect($entry->getTooltip())->toBe('Primary brand color');
});

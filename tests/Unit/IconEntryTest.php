<?php

declare(strict_types=1);

use Accelade\Infolists\Components\IconEntry;

it('can create an icon entry', function () {
    $entry = IconEntry::make('status');

    expect($entry->getName())->toBe('status');
});

it('can set icon', function () {
    $entry = IconEntry::make('status')
        ->icon('heroicon-o-check');

    expect($entry->getIcon())->toBe('heroicon-o-check');
});

it('can set icon size', function () {
    $entry = IconEntry::make('status')
        ->size('lg');

    expect($entry->getIconSize())->toBe('lg');
});

it('can set color', function () {
    $entry = IconEntry::make('status')
        ->color('success');

    expect($entry->getColor())->toBe('success');
});

it('supports boolean mode', function () {
    $entry = IconEntry::make('is_active')
        ->boolean();

    expect($entry->isBoolean())->toBeTrue();
});

it('has default true icon in boolean mode', function () {
    $entry = IconEntry::make('is_active')
        ->boolean();

    expect($entry->getTrueIcon())->toBe('heroicon-o-check-circle');
});

it('has default false icon in boolean mode', function () {
    $entry = IconEntry::make('is_active')
        ->boolean();

    expect($entry->getFalseIcon())->toBe('heroicon-o-x-circle');
});

it('can set custom true icon', function () {
    $entry = IconEntry::make('is_active')
        ->boolean()
        ->trueIcon('heroicon-o-check-badge');

    expect($entry->getTrueIcon())->toBe('heroicon-o-check-badge');
});

it('can set custom false icon', function () {
    $entry = IconEntry::make('is_active')
        ->boolean()
        ->falseIcon('heroicon-o-x-mark');

    expect($entry->getFalseIcon())->toBe('heroicon-o-x-mark');
});

it('has default true color', function () {
    $entry = IconEntry::make('is_active')
        ->boolean();

    expect($entry->getTrueColor())->toBe('success');
});

it('has default false color', function () {
    $entry = IconEntry::make('is_active')
        ->boolean();

    expect($entry->getFalseColor())->toBe('danger');
});

it('can set custom true color', function () {
    $entry = IconEntry::make('is_active')
        ->boolean()
        ->trueColor('primary');

    expect($entry->getTrueColor())->toBe('primary');
});

it('can set custom false color', function () {
    $entry = IconEntry::make('is_active')
        ->boolean()
        ->falseColor('gray');

    expect($entry->getFalseColor())->toBe('gray');
});

it('can set tooltip', function () {
    $entry = IconEntry::make('status')
        ->tooltip('Current status');

    expect($entry->getTooltip())->toBe('Current status');
});

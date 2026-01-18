<?php

declare(strict_types=1);

use Accelade\Infolists\Components\ImageEntry;

it('can create an image entry', function () {
    $entry = ImageEntry::make('avatar');

    expect($entry->getName())->toBe('avatar');
});

it('can set circular mode', function () {
    $entry = ImageEntry::make('avatar')
        ->circular();

    expect($entry->isCircular())->toBeTrue();
});

it('can set square mode', function () {
    $entry = ImageEntry::make('thumbnail')
        ->square();

    expect($entry->isSquare())->toBeTrue();
});

it('can set image size', function () {
    $entry = ImageEntry::make('avatar')
        ->size('lg');

    // size() sets width/height, getImageSize returns width as string
    expect($entry->getImageSize())->toBe('lg');
});

it('can set custom width', function () {
    $entry = ImageEntry::make('cover')
        ->width(400);

    expect($entry->getWidth())->toBe('400');
});

it('can set custom height', function () {
    $entry = ImageEntry::make('cover')
        ->height(200);

    expect($entry->getHeight())->toBe('200');
});

it('can enable stacked mode', function () {
    $entry = ImageEntry::make('team')
        ->stacked();

    expect($entry->isStacked())->toBeTrue();
});

it('can set stack limit', function () {
    $entry = ImageEntry::make('team')
        ->stacked()
        ->limit(5);

    expect($entry->getStackLimit())->toBe(5);
});

it('can set remaining count', function () {
    $entry = ImageEntry::make('team')
        ->stacked()
        ->remainingCount(10);

    expect($entry->getRemainingCount())->toBe(10);
});

it('can set url', function () {
    $entry = ImageEntry::make('photo')
        ->url('https://example.com/photo');

    expect($entry->getUrl())->toBe('https://example.com/photo');
});

it('can open url in new tab', function () {
    $entry = ImageEntry::make('photo')
        ->url('https://example.com/photo')
        ->openUrlInNewTab();

    expect($entry->shouldOpenUrlInNewTab())->toBeTrue();
});

it('can set tooltip', function () {
    $entry = ImageEntry::make('avatar')
        ->tooltip('User avatar');

    expect($entry->getTooltip())->toBe('User avatar');
});

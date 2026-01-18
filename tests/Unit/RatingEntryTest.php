<?php

declare(strict_types=1);

use Accelade\Infolists\Components\RatingEntry;

it('can create a rating entry', function () {
    $entry = RatingEntry::make('rating');

    expect($entry->getName())->toBe('rating');
});

it('has default max of 5', function () {
    $entry = RatingEntry::make('rating');

    expect($entry->getMax())->toBe(5);
});

it('can set custom max', function () {
    $entry = RatingEntry::make('rating')
        ->max(10);

    expect($entry->getMax())->toBe(10);
});

it('can set stars with custom max', function () {
    $entry = RatingEntry::make('rating')
        ->stars(10);

    expect($entry->getMax())->toBe(10);
});

it('has default star icon', function () {
    $entry = RatingEntry::make('rating');

    expect($entry->getFilledIcon())->toBe('heroicon-s-star');
    expect($entry->getEmptyIcon())->toBe('heroicon-o-star');
});

it('can use heart icons', function () {
    $entry = RatingEntry::make('rating')
        ->hearts();

    expect($entry->getFilledIcon())->toBe('heroicon-s-heart');
    expect($entry->getEmptyIcon())->toBe('heroicon-o-heart');
});

it('can set custom icons', function () {
    $entry = RatingEntry::make('rating')
        ->filledIcon('heroicon-s-check')
        ->emptyIcon('heroicon-o-x-mark');

    expect($entry->getFilledIcon())->toBe('heroicon-s-check');
    expect($entry->getEmptyIcon())->toBe('heroicon-o-x-mark');
});

it('does not allow half by default', function () {
    $entry = RatingEntry::make('rating');

    expect($entry->getAllowHalf())->toBeFalse();
});

it('can allow half stars', function () {
    $entry = RatingEntry::make('rating')
        ->allowHalf();

    expect($entry->getAllowHalf())->toBeTrue();
});

it('gets rating value from state', function () {
    $entry = RatingEntry::make('rating')
        ->record(['rating' => 4]);

    expect($entry->getRatingValue())->toBe(4.0);
});

it('returns 0 for null rating', function () {
    $entry = RatingEntry::make('rating')
        ->record([]);

    expect($entry->getRatingValue())->toBe(0.0);
});

it('has default size of md', function () {
    $entry = RatingEntry::make('rating');

    expect($entry->getRatingSize())->toBe('md');
});

it('can set rating size', function () {
    $entry = RatingEntry::make('rating')
        ->ratingSize('lg');

    expect($entry->getRatingSize())->toBe('lg');
});

it('generates correct size classes', function () {
    $entry = RatingEntry::make('rating')
        ->ratingSize('sm');

    expect($entry->getRatingSizeClasses())->toBe('w-4 h-4');
});

it('has default gold filled color', function () {
    $entry = RatingEntry::make('rating');

    expect($entry->getFilledColorClasses())->toContain('amber');
});

it('can set custom filled color', function () {
    $entry = RatingEntry::make('rating')
        ->filledColor('danger');

    expect($entry->getFilledColorClasses())->toContain('rose');
});

it('has default gray empty color', function () {
    $entry = RatingEntry::make('rating');

    expect($entry->getEmptyColorClasses())->toContain('gray');
});

it('can set custom empty color', function () {
    $entry = RatingEntry::make('rating')
        ->emptyColor('primary');

    expect($entry->getEmptyColorClasses())->toContain('primary');
});

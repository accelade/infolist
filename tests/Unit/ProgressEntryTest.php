<?php

declare(strict_types=1);

use Accelade\Infolists\Components\ProgressEntry;

it('can create a progress entry', function () {
    $entry = ProgressEntry::make('progress');

    expect($entry->getName())->toBe('progress');
});

it('has default min of 0', function () {
    $entry = ProgressEntry::make('progress');

    expect($entry->getMin())->toBe(0.0);
});

it('has default max of 100', function () {
    $entry = ProgressEntry::make('progress');

    expect($entry->getMax())->toBe(100.0);
});

it('can set custom min', function () {
    $entry = ProgressEntry::make('progress')
        ->min(10);

    expect($entry->getMin())->toBe(10.0);
});

it('can set custom max', function () {
    $entry = ProgressEntry::make('progress')
        ->max(200);

    expect($entry->getMax())->toBe(200.0);
});

it('calculates percentage correctly', function () {
    $entry = ProgressEntry::make('progress')
        ->record(['progress' => 50]);

    expect($entry->getPercentage())->toBe(50.0);
});

it('calculates percentage with custom range', function () {
    $entry = ProgressEntry::make('progress')
        ->min(0)
        ->max(200)
        ->record(['progress' => 100]);

    expect($entry->getPercentage())->toBe(50.0);
});

it('clamps percentage to 0', function () {
    $entry = ProgressEntry::make('progress')
        ->record(['progress' => -10]);

    expect($entry->getPercentage())->toBe(0.0);
});

it('clamps percentage to 100', function () {
    $entry = ProgressEntry::make('progress')
        ->record(['progress' => 150]);

    expect($entry->getPercentage())->toBe(100.0);
});

it('shows label by default', function () {
    $entry = ProgressEntry::make('progress');

    expect($entry->isShowLabel())->toBeTrue();
});

it('can hide label', function () {
    $entry = ProgressEntry::make('progress')
        ->hideLabel();

    expect($entry->isShowLabel())->toBeFalse();
});

it('is not striped by default', function () {
    $entry = ProgressEntry::make('progress');

    expect($entry->isStriped())->toBeFalse();
});

it('can be striped', function () {
    $entry = ProgressEntry::make('progress')
        ->striped();

    expect($entry->isStriped())->toBeTrue();
});

it('is not animated by default', function () {
    $entry = ProgressEntry::make('progress');

    expect($entry->isAnimated())->toBeFalse();
});

it('can be animated', function () {
    $entry = ProgressEntry::make('progress')
        ->animated();

    expect($entry->isAnimated())->toBeTrue();
    expect($entry->isStriped())->toBeTrue(); // animated implies striped
});

it('has default bar height of md', function () {
    $entry = ProgressEntry::make('progress');

    expect($entry->getBarHeight())->toBe('md');
});

it('can set bar height', function () {
    $entry = ProgressEntry::make('progress')
        ->height('lg');

    expect($entry->getBarHeight())->toBe('lg');
});

it('auto-colors as success for high percentage', function () {
    $entry = ProgressEntry::make('progress')
        ->record(['progress' => 85]);

    expect($entry->getProgressColor())->toBe('success');
});

it('auto-colors as warning for medium percentage', function () {
    $entry = ProgressEntry::make('progress')
        ->record(['progress' => 60]);

    expect($entry->getProgressColor())->toBe('warning');
});

it('auto-colors as info for low-medium percentage', function () {
    $entry = ProgressEntry::make('progress')
        ->record(['progress' => 30]);

    expect($entry->getProgressColor())->toBe('info');
});

it('auto-colors as danger for low percentage', function () {
    $entry = ProgressEntry::make('progress')
        ->record(['progress' => 20]);

    expect($entry->getProgressColor())->toBe('danger');
});

it('can set custom color', function () {
    $entry = ProgressEntry::make('progress')
        ->color('primary')
        ->record(['progress' => 50]);

    expect($entry->getProgressColor())->toBe('primary');
});

it('formats default label as percentage', function () {
    $entry = ProgressEntry::make('progress')
        ->record(['progress' => 75]);

    expect($entry->getFormattedLabel())->toBe('75%');
});

it('can use custom label format', function () {
    $entry = ProgressEntry::make('progress')
        ->labelFormat('{value} of {max}')
        ->record(['progress' => 50]);

    expect($entry->getFormattedLabel())->toBe('50 of 100');
});

it('generates correct height classes', function () {
    $entry = ProgressEntry::make('progress')
        ->height('lg');

    expect($entry->getHeightClasses())->toBe('h-4');
});

it('generates correct color classes', function () {
    $entry = ProgressEntry::make('progress')
        ->color('success');

    expect($entry->getColorClasses())->toBe('bg-emerald-500');
});

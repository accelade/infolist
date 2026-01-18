<?php

declare(strict_types=1);

use Accelade\Infolists\Components\TextEntry;

it('can create a text entry', function () {
    $entry = TextEntry::make('name');

    expect($entry->getName())->toBe('name');
});

it('generates label from name', function () {
    $entry = TextEntry::make('first_name');

    expect($entry->getLabel())->toBe('First name');
});

it('can set custom label', function () {
    $entry = TextEntry::make('name')
        ->label('Full Name');

    expect($entry->getLabel())->toBe('Full Name');
});

it('can set state from record', function () {
    $entry = TextEntry::make('name')
        ->record(['name' => 'John Doe']);

    expect($entry->getState())->toBe('John Doe');
});

it('can set explicit state', function () {
    $entry = TextEntry::make('name')
        ->state('Jane Doe');

    expect($entry->getState())->toBe('Jane Doe');
});

it('can set default state', function () {
    $entry = TextEntry::make('name')
        ->record(['other' => 'value'])
        ->default('N/A');

    expect($entry->getState())->toBe('N/A');
});

it('formats as date', function () {
    $entry = TextEntry::make('created_at')
        ->record(['created_at' => '2024-01-15 10:30:00'])
        ->date();

    expect($entry->getFormattedState())->toContain('Jan');
});

it('formats as money', function () {
    $entry = TextEntry::make('price')
        ->record(['price' => 4999])
        ->money('USD');

    expect($entry->getFormattedState())->toContain('$');
    expect($entry->getFormattedState())->toContain('4,999');
});

it('limits text length', function () {
    $entry = TextEntry::make('description')
        ->record(['description' => 'This is a very long description that should be truncated'])
        ->limit(20);

    expect(strlen($entry->getFormattedState()))->toBeLessThanOrEqual(23); // 20 + '...'
});

it('can set icon', function () {
    $entry = TextEntry::make('email')
        ->icon('heroicon-o-envelope');

    expect($entry->getIcon())->toBe('heroicon-o-envelope');
});

it('can set color', function () {
    $entry = TextEntry::make('status')
        ->color('success');

    expect($entry->getColor())->toBe('success');
});

it('can be badge', function () {
    $entry = TextEntry::make('status')
        ->badge();

    expect($entry->isBadge())->toBeTrue();
});

it('can be copyable', function () {
    $entry = TextEntry::make('api_key')
        ->copyable();

    expect($entry->isCopyable())->toBeTrue();
});

it('can set url', function () {
    $entry = TextEntry::make('website')
        ->url('https://example.com');

    expect($entry->getUrl())->toBe('https://example.com');
});

it('can open url in new tab', function () {
    $entry = TextEntry::make('website')
        ->url('https://example.com')
        ->openUrlInNewTab();

    expect($entry->shouldOpenUrlInNewTab())->toBeTrue();
});

it('can be hidden', function () {
    $entry = TextEntry::make('secret')
        ->hidden();

    expect($entry->isHidden())->toBeTrue();
});

it('can be hidden conditionally', function () {
    $entry = TextEntry::make('secret')
        ->hidden(fn () => true);

    expect($entry->isHidden())->toBeTrue();
});

it('can be visible conditionally', function () {
    $entry = TextEntry::make('secret')
        ->visible(fn () => false);

    expect($entry->isHidden())->toBeTrue();
});

it('can set column span', function () {
    $entry = TextEntry::make('description')
        ->columnSpan(2);

    expect($entry->getColumnSpan())->toBe(2);
});

it('can set column span full', function () {
    $entry = TextEntry::make('description')
        ->columnSpanFull();

    expect($entry->getColumnSpan())->toBe('full');
});

it('can set size', function () {
    $entry = TextEntry::make('title')
        ->size('lg');

    expect($entry->getSize())->toBe('lg');
});

it('can set weight', function () {
    $entry = TextEntry::make('title')
        ->weight('bold');

    expect($entry->getWeight())->toBe('bold');
});

it('can set tooltip', function () {
    $entry = TextEntry::make('abbreviation')
        ->tooltip('Full explanation here');

    expect($entry->getTooltip())->toBe('Full explanation here');
});

it('can format state using closure', function () {
    $entry = TextEntry::make('status')
        ->record(['status' => 'active'])
        ->formatStateUsing(fn ($state) => strtoupper($state));

    expect($entry->getFormattedState())->toBe('ACTIVE');
});

it('supports nested data with dot notation', function () {
    $entry = TextEntry::make('user.name')
        ->record(['user' => ['name' => 'John']]);

    expect($entry->getState())->toBe('John');
});

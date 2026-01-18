<?php

declare(strict_types=1);

use Accelade\Infolists\Components\RepeatableEntry;
use Accelade\Infolists\Components\TextEntry;

it('can create a repeatable entry', function () {
    $entry = RepeatableEntry::make('comments');

    expect($entry->getName())->toBe('comments');
});

it('can set schema', function () {
    $entry = RepeatableEntry::make('comments')
        ->schema([
            TextEntry::make('author'),
            TextEntry::make('content'),
        ]);

    expect($entry->getSchema())->toHaveCount(2);
});

it('can enable contained mode', function () {
    $entry = RepeatableEntry::make('comments')
        ->contained();

    expect($entry->isContained())->toBeTrue();
});

it('can enable grid mode', function () {
    $entry = RepeatableEntry::make('items')
        ->grid();

    expect($entry->isGrid())->toBeTrue();
});

it('can set grid columns', function () {
    $entry = RepeatableEntry::make('items')
        ->grid()
        ->gridColumns(3);

    expect($entry->getGridColumns())->toBe(3);
});

it('can get state from record', function () {
    $comments = [
        ['author' => 'Alice', 'content' => 'Great!'],
        ['author' => 'Bob', 'content' => 'Thanks!'],
    ];

    $entry = RepeatableEntry::make('comments')
        ->record(['comments' => $comments]);

    expect($entry->getState())->toBe($comments);
});

it('can set placeholder', function () {
    $entry = RepeatableEntry::make('comments')
        ->placeholder('No comments yet');

    expect($entry->getPlaceholder())->toBe('No comments yet');
});

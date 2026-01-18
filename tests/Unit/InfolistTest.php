<?php

declare(strict_types=1);

use Accelade\Infolists\Components\TextEntry;
use Accelade\Infolists\Infolist;

it('can create an infolist', function () {
    $infolist = Infolist::make();

    expect($infolist)->toBeInstanceOf(Infolist::class);
});

it('can set record', function () {
    $record = ['name' => 'John', 'email' => 'john@example.com'];

    $infolist = Infolist::make()
        ->record($record);

    expect($infolist->getRecord())->toBe($record);
});

it('can set schema', function () {
    $infolist = Infolist::make()
        ->schema([
            TextEntry::make('name'),
            TextEntry::make('email'),
        ]);

    expect($infolist->getSchema())->toHaveCount(2);
});

it('can set columns', function () {
    $infolist = Infolist::make()
        ->columns(3);

    expect($infolist->getColumns())->toBe(3);
});

it('passes record to entries via getEntries', function () {
    $record = ['name' => 'John'];

    $infolist = Infolist::make()
        ->record($record)
        ->schema([
            TextEntry::make('name'),
        ]);

    // Use getEntries() which sets the record on entries
    $entries = $infolist->getEntries();

    expect($entries[0]->getRecord())->toBe($record);
});

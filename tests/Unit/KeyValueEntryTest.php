<?php

declare(strict_types=1);

use Accelade\Infolists\Components\KeyValueEntry;

it('can create a key value entry', function () {
    $entry = KeyValueEntry::make('metadata');

    expect($entry->getName())->toBe('metadata');
});

it('can get state from record', function () {
    $data = ['version' => '1.0.0', 'author' => 'Accelade'];
    $entry = KeyValueEntry::make('metadata')
        ->record(['metadata' => $data]);

    expect($entry->getState())->toBe($data);
});

it('can set key label', function () {
    $entry = KeyValueEntry::make('metadata')
        ->keyLabel('Property');

    expect($entry->getKeyLabel())->toBe('Property');
});

it('can set value label', function () {
    $entry = KeyValueEntry::make('metadata')
        ->valueLabel('Setting');

    expect($entry->getValueLabel())->toBe('Setting');
});

it('can set placeholder', function () {
    $entry = KeyValueEntry::make('metadata')
        ->placeholder('No metadata available');

    expect($entry->getPlaceholder())->toBe('No metadata available');
});

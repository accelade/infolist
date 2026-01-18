<?php

declare(strict_types=1);

use Accelade\Infolists\Components\SeparatorEntry;

it('can create a separator entry', function () {
    $entry = SeparatorEntry::make('divider');

    expect($entry->getName())->toBe('divider');
});

it('is horizontal by default', function () {
    $entry = SeparatorEntry::make('divider');

    expect($entry->isHorizontal())->toBeTrue();
    expect($entry->isVertical())->toBeFalse();
});

it('can be vertical', function () {
    $entry = SeparatorEntry::make('divider')
        ->vertical();

    expect($entry->isVertical())->toBeTrue();
    expect($entry->isHorizontal())->toBeFalse();
});

it('can switch back to horizontal', function () {
    $entry = SeparatorEntry::make('divider')
        ->vertical()
        ->horizontal();

    expect($entry->isHorizontal())->toBeTrue();
});

it('has default gray color', function () {
    $entry = SeparatorEntry::make('divider');

    expect($entry->getSeparatorColor())->toBe('gray');
});

it('can set custom color', function () {
    $entry = SeparatorEntry::make('divider')
        ->separatorColor('primary');

    expect($entry->getSeparatorColor())->toBe('primary');
});

it('is solid by default', function () {
    $entry = SeparatorEntry::make('divider');

    expect($entry->getSeparatorStyle())->toBe('solid');
});

it('can be dashed', function () {
    $entry = SeparatorEntry::make('divider')
        ->dashed();

    expect($entry->getSeparatorStyle())->toBe('dashed');
});

it('can be dotted', function () {
    $entry = SeparatorEntry::make('divider')
        ->dotted();

    expect($entry->getSeparatorStyle())->toBe('dotted');
});

it('is thin by default', function () {
    $entry = SeparatorEntry::make('divider');

    expect($entry->getThickness())->toBe('thin');
});

it('can be medium thickness', function () {
    $entry = SeparatorEntry::make('divider')
        ->medium();

    expect($entry->getThickness())->toBe('medium');
});

it('can be thick', function () {
    $entry = SeparatorEntry::make('divider')
        ->thick();

    expect($entry->getThickness())->toBe('thick');
});

it('has no text by default', function () {
    $entry = SeparatorEntry::make('divider');

    expect($entry->getText())->toBeNull();
});

it('can have text', function () {
    $entry = SeparatorEntry::make('divider')
        ->text('OR');

    expect($entry->getText())->toBe('OR');
});

it('has centered text by default', function () {
    $entry = SeparatorEntry::make('divider')
        ->text('OR');

    expect($entry->getTextPosition())->toBe('center');
});

it('can have left aligned text', function () {
    $entry = SeparatorEntry::make('divider')
        ->text('Section')
        ->textLeft();

    expect($entry->getTextPosition())->toBe('left');
});

it('can have right aligned text', function () {
    $entry = SeparatorEntry::make('divider')
        ->text('Section')
        ->textRight();

    expect($entry->getTextPosition())->toBe('right');
});

it('generates correct color classes', function () {
    $entry = SeparatorEntry::make('divider')
        ->separatorColor('success');

    expect($entry->getSeparatorColorClasses())->toContain('emerald');
});

it('generates correct thickness classes for horizontal', function () {
    $entry = SeparatorEntry::make('divider')
        ->medium();

    expect($entry->getThicknessClasses())->toBe('border-t-2');
});

it('generates correct thickness classes for vertical', function () {
    $entry = SeparatorEntry::make('divider')
        ->vertical()
        ->medium();

    expect($entry->getThicknessClasses())->toBe('border-l-2');
});

it('generates correct style classes', function () {
    $entry = SeparatorEntry::make('divider')
        ->dashed();

    expect($entry->getStyleClasses())->toBe('border-dashed');
});

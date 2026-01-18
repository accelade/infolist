<?php

declare(strict_types=1);

use Accelade\Infolists\Components\HtmlEntry;

it('can create an html entry', function () {
    $entry = HtmlEntry::make('content');

    expect($entry->getName())->toBe('content');
});

it('is not markdown by default', function () {
    $entry = HtmlEntry::make('content');

    expect($entry->isMarkdownContent())->toBeFalse();
});

it('can be markdown', function () {
    $entry = HtmlEntry::make('content')
        ->markdown();

    expect($entry->isMarkdownContent())->toBeTrue();
});

it('can switch to html mode', function () {
    $entry = HtmlEntry::make('content')
        ->markdown()
        ->html();

    expect($entry->isMarkdownContent())->toBeFalse();
});

it('uses prose by default', function () {
    $entry = HtmlEntry::make('content');

    expect($entry->isProse())->toBeTrue();
});

it('can disable prose', function () {
    $entry = HtmlEntry::make('content')
        ->prose(false);

    expect($entry->isProse())->toBeFalse();
});

it('is sanitized by default', function () {
    $entry = HtmlEntry::make('content');

    expect($entry->isSanitized())->toBeTrue();
});

it('can be unsanitized', function () {
    $entry = HtmlEntry::make('content')
        ->unsanitized();

    expect($entry->isSanitized())->toBeFalse();
});

it('can set sanitized explicitly', function () {
    $entry = HtmlEntry::make('content')
        ->unsanitized()
        ->sanitized();

    expect($entry->isSanitized())->toBeTrue();
});

it('has no max height by default', function () {
    $entry = HtmlEntry::make('content');

    expect($entry->getMaxHeight())->toBeNull();
});

it('can set max height', function () {
    $entry = HtmlEntry::make('content')
        ->maxHeight('200px');

    expect($entry->getMaxHeight())->toBe('200px');
});

it('returns formatted content', function () {
    $entry = HtmlEntry::make('content')
        ->record(['content' => '<p>Hello World</p>']);

    expect($entry->getFormattedContent())->toBe('<p>Hello World</p>');
});

it('converts markdown to html', function () {
    $entry = HtmlEntry::make('content')
        ->markdown()
        ->record(['content' => '**Bold Text**']);

    $content = $entry->getFormattedContent();

    expect($content)->toContain('<strong>');
    expect($content)->toContain('Bold Text');
});

it('returns null for empty content', function () {
    $entry = HtmlEntry::make('content')
        ->record(['content' => '']);

    expect($entry->getFormattedContent())->toBeNull();
});

it('returns null for null content', function () {
    $entry = HtmlEntry::make('content')
        ->record([]);

    expect($entry->getFormattedContent())->toBeNull();
});

it('can set allowed tags', function () {
    $entry = HtmlEntry::make('content')
        ->allowedTags(['<p>', '<strong>']);

    // Just verify the method works
    expect($entry)->toBeInstanceOf(HtmlEntry::class);
});

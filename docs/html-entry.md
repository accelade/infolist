# HTML Entry

The HtmlEntry component displays HTML content or renders Markdown as HTML.

## Basic Usage

```php
use Accelade\Infolists\Components\HtmlEntry;

HtmlEntry::make('description')
    ->label('Description'),
```

## HTML Mode

Display raw HTML content (default):

```php
HtmlEntry::make('content')
    ->html()
    ->label('Rich Content'),
```

## Markdown Mode

Render Markdown content as HTML:

```php
HtmlEntry::make('readme')
    ->markdown()
    ->label('README'),
```

## Prose Styling

Apply prose typography styling (enabled by default):

```php
// With prose styling (default)
HtmlEntry::make('article')
    ->prose()
    ->markdown(),

// Without prose styling
HtmlEntry::make('content')
    ->prose(false),
```

## Sanitization

Control HTML sanitization:

```php
// Sanitized (default) - strips potentially dangerous tags
HtmlEntry::make('user_content')
    ->sanitized(),

// Unsanitized - allows all HTML (use with caution!)
HtmlEntry::make('trusted_content')
    ->unsanitized(),
```

## Allowed Tags

Specify which HTML tags are allowed when sanitizing:

```php
HtmlEntry::make('content')
    ->allowedTags(['<p>', '<strong>', '<em>', '<a>', '<ul>', '<li>']),
```

## Max Height

Limit the height with scrolling:

```php
HtmlEntry::make('long_content')
    ->markdown()
    ->maxHeight('300px'),
```

## Complete Example

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\HtmlEntry;
use Accelade\Infolists\Components\TextEntry;

Infolist::make()
    ->record($article)
    ->columns(1)
    ->schema([
        TextEntry::make('title')
            ->label('Title')
            ->size('xl')
            ->weight('bold'),

        TextEntry::make('author.name')
            ->label('Author'),

        HtmlEntry::make('summary')
            ->label('Summary')
            ->html()
            ->prose(),

        HtmlEntry::make('body')
            ->label('Content')
            ->markdown()
            ->prose()
            ->maxHeight('500px'),

        HtmlEntry::make('changelog')
            ->label('Changelog')
            ->markdown()
            ->prose(false)
            ->maxHeight('200px'),
    ]);
```

## Standalone Blade Component

Use the HTML entry directly in Blade without the Infolist class:

```blade
<x-infolist::html-entry
    label="Description"
    value="<p>This is <strong>formatted</strong> HTML content.</p>"
/>

<x-infolist::html-entry
    label="README"
    value="# Welcome\n\nThis is **markdown** content."
    :markdown="true"
    :prose="true"
/>

<x-infolist::html-entry
    label="Long Content"
    value="<p>Very long content here...</p>"
    maxHeight="200px"
/>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string | null | HTML or Markdown content |
| `label` | string | null | The label text |
| `helperText` | string | null | Helper text below the content |
| `placeholder` | string | '—' | Placeholder when no content |
| `markdown` | bool | false | Render value as Markdown |
| `prose` | bool | true | Apply prose typography styling |
| `maxHeight` | string | null | Max height with scrolling (e.g., '200px') |
| `sanitized` | bool | true | Sanitize HTML (strip dangerous tags) |

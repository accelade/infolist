# Markdown Entry

The MarkdownEntry component renders markdown content with GitHub-flavored markdown styling, matching the documentation prose style.

## Basic Usage

```php
use Accelade\Infolists\Components\MarkdownEntry;

MarkdownEntry::make('description')
    ->label('Description'),
```

## Features

The MarkdownEntry supports all GitHub-flavored markdown features:

- **Headings** (h1-h6) with bottom borders
- **Bold** and *italic* text
- [Links](#) with accent color
- `Inline code` with background
- Code blocks with syntax highlighting
- Lists (ordered, unordered, nested)
- Task lists with checkboxes
- Tables with zebra striping
- Blockquotes
- Horizontal rules
- Images
- Definition lists
- Keyboard keys (`<kbd>`)

## Max Height

Set a maximum height with scrolling for long content:

```php
MarkdownEntry::make('long_content')
    ->label('Article')
    ->maxHeight('300px'),
```

## Collapsible Content

Make long content collapsible:

```php
MarkdownEntry::make('readme')
    ->label('README')
    ->collapsible(),

// Start collapsed
MarkdownEntry::make('changelog')
    ->label('Changelog')
    ->collapsed(),

// Custom collapsed height
MarkdownEntry::make('documentation')
    ->label('Docs')
    ->collapsible()
    ->collapsedHeight('200px'),
```

## Complete Example

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\MarkdownEntry;

Infolist::make()
    ->record($article)
    ->schema([
        MarkdownEntry::make('summary')
            ->label('Summary'),

        MarkdownEntry::make('content')
            ->label('Full Content')
            ->collapsible()
            ->collapsedHeight('200px'),

        MarkdownEntry::make('technical_notes')
            ->label('Technical Notes')
            ->maxHeight('400px'),
    ]);
```

## Standalone Blade Component

Use the markdown entry directly in Blade without the Infolist class:

```blade
<x-infolist::markdown-entry
    label="Description"
    :value="$markdownContent"
/>

<x-infolist::markdown-entry
    label="README"
    :value="$readme"
    :collapsible="true"
    :collapsed="true"
/>

<x-infolist::markdown-entry
    label="Documentation"
    :value="$docs"
    maxHeight="300px"
/>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string | null | Markdown content to render |
| `label` | string | null | The label text |
| `helperText` | string | null | Helper text below the content |
| `placeholder` | string | '—' | Placeholder when no content |
| `maxHeight` | string | null | Maximum height with scrolling (e.g., '300px') |
| `collapsible` | bool | false | Make content collapsible |
| `collapsed` | bool | false | Start in collapsed state |
| `collapsedHeight` | string | '150px' | Height when collapsed |

## Styling

The MarkdownEntry uses CSS variables that adapt to light and dark modes:

- `--docs-text` - Main text color
- `--docs-text-muted` - Muted/secondary text color
- `--docs-bg` - Background color
- `--docs-bg-alt` - Alternative background (code blocks, table headers)
- `--docs-border` - Border color
- `--docs-accent` - Accent color (links)

These variables are automatically set by the documentation layout and will inherit the correct values in both light and dark modes.

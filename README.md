# Accelade Infolists

<p align="center">
<strong>Display read-only information with Filament-compatible API</strong>
</p>

<p align="center">
<a href="https://github.com/accelade/infolists/actions/workflows/tests.yml"><img src="https://github.com/accelade/infolists/actions/workflows/tests.yml/badge.svg" alt="Tests"></a>
<a href="https://packagist.org/packages/accelade/infolists"><img src="https://img.shields.io/packagist/v/accelade/infolists" alt="Latest Version"></a>
<a href="https://packagist.org/packages/accelade/infolists"><img src="https://img.shields.io/packagist/dt/accelade/infolists" alt="Total Downloads"></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="License"></a>
</p>

---

Build beautiful, read-only information displays using a Filament-compatible API. Perfect for detail views, dashboards, and anywhere you need to present data elegantly.

```php
use Accelade\Infolist\Infolist;
use Accelade\Infolist\Components\TextEntry;
use Accelade\Infolist\Components\ImageEntry;
use Accelade\Infolist\Components\BadgeEntry;

Infolist::make()
    ->record($user)
    ->schema([
        ImageEntry::make('avatar')->circular(),
        TextEntry::make('name')->size('lg')->weight('bold'),
        TextEntry::make('email')->icon('heroicon-o-envelope'),
        BadgeEntry::make('status')->color('success'),
    ]);
```

---

## Why Accelade Infolists?

- **Filament-Compatible API** — Familiar fluent interface if you've used Filament
- **15+ Entry Types** — Text, images, badges, icons, colors, QR codes, and more
- **Standalone Components** — Use entries directly in Blade without the Infolist class
- **Dark Mode Support** — Automatic light/dark theming with CSS variables
- **Responsive Layouts** — Grid system with column spans and responsive breakpoints
- **Lightweight** — No heavy dependencies, works with any Laravel app

---

## Quick Start

```bash
composer require accelade/infolists
```

Display user information:

```php
use Accelade\Infolist\Infolist;
use Accelade\Infolist\Components\TextEntry;
use Accelade\Infolist\Components\ImageEntry;

$infolist = Infolist::make()
    ->record($user)
    ->columns(2)
    ->schema([
        ImageEntry::make('avatar')
            ->circular()
            ->size(80),

        TextEntry::make('name')
            ->label('Full Name')
            ->size('lg')
            ->weight('bold'),

        TextEntry::make('email')
            ->icon('heroicon-o-envelope')
            ->copyable(),

        TextEntry::make('created_at')
            ->label('Member Since')
            ->dateTime('M j, Y'),
    ]);
```

Render in Blade:

```blade
<x-infolist::infolist :infolist="$infolist" />
```

Or use standalone components directly:

```blade
<x-infolist::text-entry label="Name" :value="$user->name" />
<x-infolist::badge-entry label="Status" value="Active" color="success" />
```

---

## Entry Components

### Text Entry
Display text with formatting, icons, badges, and more.

```php
TextEntry::make('title')
    ->label('Article Title')
    ->size('lg')
    ->weight('bold')
    ->color('primary')
    ->icon('heroicon-o-document')
    ->copyable();

TextEntry::make('price')
    ->money('USD');

TextEntry::make('published_at')
    ->dateTime('M j, Y');

TextEntry::make('tags')
    ->badge()
    ->badgeColor('info');
```

### Badge Entry
Display values as styled badges with color mapping.

```php
BadgeEntry::make('status')
    ->colors([
        'active' => 'success',
        'pending' => 'warning',
        'inactive' => 'danger',
    ]);
```

### Image Entry
Display single or multiple images with various styles.

```php
ImageEntry::make('avatar')
    ->circular()
    ->size(64);

ImageEntry::make('gallery')
    ->stacked()
    ->limit(5)
    ->size(48);
```

### Icon Entry
Display icons with boolean mode support.

```php
IconEntry::make('is_verified')
    ->boolean()
    ->trueIcon('heroicon-o-check-circle')
    ->falseIcon('heroicon-o-x-circle');
```

### Color Entry
Display color swatches.

```php
ColorEntry::make('brand_color')
    ->copyable();
```

### Rating Entry
Display star or heart ratings.

```php
RatingEntry::make('score')
    ->max(5)
    ->icon('heroicon-s-star')
    ->color('warning');
```

### Progress Entry
Display progress bars.

```php
ProgressEntry::make('completion')
    ->color('success')
    ->showValue();
```

### Code Entry
Display code snippets with syntax highlighting.

```php
CodeEntry::make('config')
    ->language('json')
    ->copyable();
```

### QR Code Entry
Generate QR codes and barcodes.

```php
QrCodeEntry::make('url')
    ->size(150);

QrCodeEntry::make('sku')
    ->barcode('CODE128');
```

### Key-Value Entry
Display key-value pairs.

```php
KeyValueEntry::make('metadata');
```

### Repeatable Entry
Display repeated data with nested schemas.

```php
RepeatableEntry::make('comments')
    ->schema([
        TextEntry::make('author'),
        TextEntry::make('body'),
    ])
    ->grid(2);
```

### Markdown Entry
Render markdown content with GitHub-flavored styling.

```php
MarkdownEntry::make('description')
    ->collapsible()
    ->collapsed();
```

### HTML Entry
Display HTML or rendered markdown.

```php
HtmlEntry::make('content')
    ->prose()
    ->maxHeight('300px');
```

### Secret Entry
Display masked sensitive data.

```php
SecretEntry::make('api_key')
    ->revealable();
```

### Separator Entry
Add horizontal dividers.

```php
SeparatorEntry::make();
```

---

## Layouts

### Grid Columns

```php
Infolist::make()
    ->columns(3)
    ->schema([
        TextEntry::make('name')->columnSpan(2),
        TextEntry::make('status'),
        TextEntry::make('bio')->columnSpanFull(),
    ]);
```

### Responsive Columns

```php
Infolist::make()
    ->columns([
        'default' => 1,
        'sm' => 2,
        'lg' => 3,
    ])
    ->schema([...]);
```

---

## Standalone Blade Components

Use any entry directly in Blade without creating an Infolist:

```blade
<x-infolist::text-entry
    label="Email"
    :value="$user->email"
    icon="heroicon-o-envelope"
/>

<x-infolist::badge-entry
    label="Status"
    value="Active"
    color="success"
/>

<x-infolist::image-entry
    label="Avatar"
    :value="$user->avatar_url"
    :circular="true"
    :size="64"
/>

<x-infolist::rating-entry
    label="Score"
    :value="4"
    :max="5"
/>

<x-infolist::markdown-entry
    label="Description"
    :value="$markdownContent"
    :collapsible="true"
/>
```

---

## Requirements

- PHP 8.2+
- Laravel 11.x or 12.x
- [Accelade](https://github.com/accelade/accelade) (core package)

---

## Documentation

| Guide | Description |
|-------|-------------|
| [Getting Started](docs/getting-started.md) | Installation and basic usage |
| [Text Entry](docs/text-entry.md) | Text display with formatting |
| [Badge Entry](docs/badge-entry.md) | Styled badge displays |
| [Icon Entry](docs/icon-entry.md) | Icon displays with boolean mode |
| [Image Entry](docs/image-entry.md) | Single and multiple images |
| [Color Entry](docs/color-entry.md) | Color swatch displays |
| [Rating Entry](docs/rating-entry.md) | Star and heart ratings |
| [Progress Entry](docs/progress-entry.md) | Progress bar displays |
| [Code Entry](docs/code-entry.md) | Syntax highlighted code |
| [QR Code Entry](docs/qr-code-entry.md) | QR codes and barcodes |
| [Key-Value Entry](docs/key-value-entry.md) | Key-value pair displays |
| [Repeatable Entry](docs/repeatable-entry.md) | Repeated data with nested schema |
| [Markdown Entry](docs/markdown-entry.md) | GitHub-flavored markdown |
| [HTML Entry](docs/html-entry.md) | HTML and prose content |
| [Secret Entry](docs/secret-entry.md) | Masked sensitive data |
| [Separator Entry](docs/separator-entry.md) | Horizontal dividers |
| [API Reference](docs/api-reference.md) | Complete API documentation |

---

## Credits

Built as part of the [Accelade](https://github.com/accelade/accelade) ecosystem, with inspiration from [Filament](https://filamentphp.com).

---

## License

MIT License. See [LICENSE](LICENSE) for details.

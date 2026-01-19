# Text Entry

The TextEntry component displays text values with rich formatting options.

## Basic Usage

```php
use Accelade\Infolists\Components\TextEntry;

TextEntry::make('name')
    ->label('Full Name'),
```

## Formatting

### Date & Time

```php
TextEntry::make('created_at')
    ->date(),

TextEntry::make('published_at')
    ->dateTime(),

TextEntry::make('updated_at')
    ->since(), // "2 hours ago"

TextEntry::make('event_date')
    ->date('F j, Y'), // Custom format
```

### Currency & Numbers

```php
TextEntry::make('price')
    ->money('USD'),

TextEntry::make('amount')
    ->numeric(decimalPlaces: 2, thousandsSeparator: ','),
```

### Text Limits

```php
TextEntry::make('description')
    ->limit(100),

TextEntry::make('content')
    ->words(50),
```

### Rich Text

```php
TextEntry::make('bio')
    ->markdown(),

TextEntry::make('content')
    ->html(),
```

## Lists

Display arrays as lists:

```php
TextEntry::make('tags')
    ->listWithLineBreaks(),

TextEntry::make('categories')
    ->bulleted(),

TextEntry::make('skills')
    ->separator(', '),
```

## Icons

```php
TextEntry::make('email')
    ->icon('heroicon-o-envelope'),

TextEntry::make('phone')
    ->icon('heroicon-o-phone')
    ->iconPosition('after'),
```

## Colors

```php
TextEntry::make('status')
    ->color('success'),

TextEntry::make('priority')
    ->color(fn ($state) => match ($state) {
        'high' => 'danger',
        'medium' => 'warning',
        default => 'gray',
    }),
```

## Badges

```php
TextEntry::make('status')
    ->badge(),

TextEntry::make('role')
    ->badge()
    ->color('primary'),
```

## Copyable

```php
TextEntry::make('api_key')
    ->copyable()
    ->copyMessage('API key copied!')
    ->copyMessageDuration(3000),
```

## URLs

```php
TextEntry::make('website')
    ->url(fn ($record) => $record->website),

TextEntry::make('profile')
    ->url(fn ($record) => route('users.show', $record))
    ->openUrlInNewTab(),
```

## Size & Weight

```php
TextEntry::make('title')
    ->size('lg')
    ->weight('bold'),

// Available sizes: xs, sm, md, lg, xl, 2xl
// Available weights: thin, light, normal, medium, semibold, bold, black
```

## Visibility

```php
TextEntry::make('secret')
    ->hidden(fn ($record) => ! $record->is_admin),

TextEntry::make('internal_notes')
    ->visible(fn () => auth()->user()->isAdmin()),
```

## Custom State

```php
TextEntry::make('full_name')
    ->state(fn ($record) => "{$record->first_name} {$record->last_name}"),

TextEntry::make('status')
    ->formatStateUsing(fn ($state) => ucfirst($state)),
```

## Placeholder

```php
TextEntry::make('bio')
    ->placeholder('No biography provided'),
```

## Helper Text & Hints

```php
TextEntry::make('email')
    ->helperText('This is the primary contact email'),

TextEntry::make('api_key')
    ->hint('Keep this secret!')
    ->hintIcon('heroicon-o-exclamation-triangle')
    ->hintColor('warning'),
```

## Tooltips

```php
TextEntry::make('abbreviated_name')
    ->tooltip(fn ($record) => $record->full_name),
```

## Standalone Blade Component

Use the text entry directly in Blade without the Infolist class:

```blade
<x-accelade::text-entry
    label="Name"
    value="John Doe"
/>

<x-accelade::text-entry
    label="Email"
    value="john@example.com"
    icon="heroicon-o-envelope"
    iconPosition="before"
/>

<x-accelade::text-entry
    label="Price"
    value="$99.00"
    size="lg"
    weight="bold"
    color="success"
/>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string | null | The text value to display |
| `label` | string | null | The label text |
| `helperText` | string | null | Helper text below the value |
| `placeholder` | string | '-' | Placeholder when value is empty |
| `icon` | string | null | Heroicon name |
| `iconPosition` | string | 'before' | Icon position: 'before' or 'after' |
| `iconColor` | string | null | Icon color |
| `size` | string | 'md' | Text size: xs, sm, md, lg, xl, 2xl |
| `weight` | string | 'normal' | Font weight |
| `color` | string | null | Text color |
| `badge` | bool | false | Display as badge |
| `badgeColor` | string | 'primary' | Badge color |
| `copyable` | bool | false | Enable copy to clipboard |
| `copyMessage` | string | 'Copied!' | Message after copying |
| `url` | string | null | Make text a link |
| `openUrlInNewTab` | bool | false | Open link in new tab |

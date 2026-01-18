# Color Entry

The ColorEntry component displays color swatches with their hex/rgb values.

## Basic Usage

```php
use Accelade\Infolists\Components\ColorEntry;

ColorEntry::make('brand_color')
    ->label('Brand Color'),
```

The state should be a valid CSS color value (hex, rgb, hsl, etc.).

## Copyable

Allow users to copy the color value:

```php
ColorEntry::make('primary_color')
    ->copyable(),

ColorEntry::make('accent_color')
    ->copyable()
    ->copyMessage('Color copied!')
    ->copyMessageDuration(3000),
```

## Tooltips

```php
ColorEntry::make('theme_color')
    ->tooltip('Click to copy'),
```

## Visibility

```php
ColorEntry::make('admin_color')
    ->hidden(fn () => ! auth()->user()->isAdmin()),
```

## Complete Example

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\ColorEntry;

Infolist::make()
    ->record($theme)
    ->columns(3)
    ->schema([
        ColorEntry::make('primary_color')
            ->label('Primary')
            ->copyable(),

        ColorEntry::make('secondary_color')
            ->label('Secondary')
            ->copyable(),

        ColorEntry::make('accent_color')
            ->label('Accent')
            ->copyable(),

        ColorEntry::make('background_color')
            ->label('Background')
            ->copyable(),

        ColorEntry::make('text_color')
            ->label('Text')
            ->copyable(),

        ColorEntry::make('border_color')
            ->label('Border')
            ->copyable(),
    ]);
```

## Standalone Blade Component

Use the color entry directly in Blade without the Infolist class:

```blade
<x-infolist::color-entry
    label="Primary Color"
    value="#3B82F6"
/>

<x-infolist::color-entry
    label="Brand Color"
    value="#10B981"
    :copyable="true"
    copyMessage="Color copied!"
/>

<x-infolist::color-entry
    label="Theme Color"
    value="rgb(139, 92, 246)"
    tooltip="Click to copy"
    :copyable="true"
/>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string | null | CSS color value (hex, rgb, hsl, etc.) |
| `label` | string | null | The label text |
| `helperText` | string | null | Helper text below the swatch |
| `placeholder` | string | '-' | Placeholder when no value |
| `copyable` | bool | false | Allow copying the color value |
| `copyMessage` | string | 'Copied!' | Message shown after copying |
| `copyMessageDuration` | int | 2000 | Duration to show copy message (ms) |
| `tooltip` | string | null | Tooltip text on hover |

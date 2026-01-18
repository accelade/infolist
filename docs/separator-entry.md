# Separator Entry

The SeparatorEntry component displays horizontal or vertical divider lines between entries.

## Basic Usage

```php
use Accelade\Infolists\Components\SeparatorEntry;

SeparatorEntry::make('divider'),
```

## Orientation

### Horizontal (Default)

```php
SeparatorEntry::make('divider')
    ->horizontal(),
```

### Vertical

```php
SeparatorEntry::make('divider')
    ->vertical(),
```

## Line Style

### Solid (Default)

```php
SeparatorEntry::make('divider')
    ->solid(),
```

### Dashed

```php
SeparatorEntry::make('divider')
    ->dashed(),
```

### Dotted

```php
SeparatorEntry::make('divider')
    ->dotted(),
```

## Thickness

```php
SeparatorEntry::make('divider')
    ->thin(),    // Thin line (default)

SeparatorEntry::make('divider')
    ->medium(),  // Medium line

SeparatorEntry::make('divider')
    ->thick(),   // Thick line
```

## Color

```php
SeparatorEntry::make('divider')
    ->separatorColor('primary'),

SeparatorEntry::make('divider')
    ->separatorColor('gray'),     // Default

SeparatorEntry::make('divider')
    ->separatorColor('success'),

SeparatorEntry::make('divider')
    ->separatorColor('danger'),

SeparatorEntry::make('divider')
    ->separatorColor('warning'),
```

## Text Divider

Add text in the middle of the divider:

```php
SeparatorEntry::make('divider')
    ->text('OR'),

// Text alignment
SeparatorEntry::make('divider')
    ->text('Section Title')
    ->textLeft(),

SeparatorEntry::make('divider')
    ->text('OR')
    ->textCenter(),  // Default

SeparatorEntry::make('divider')
    ->text('End')
    ->textRight(),
```

## Complete Example

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\SeparatorEntry;
use Accelade\Infolists\Components\TextEntry;

Infolist::make()
    ->record($user)
    ->schema([
        TextEntry::make('name')
            ->label('Name'),

        TextEntry::make('email')
            ->label('Email'),

        SeparatorEntry::make('personal_info_divider')
            ->text('Contact Information')
            ->textLeft()
            ->dashed(),

        TextEntry::make('phone')
            ->label('Phone'),

        TextEntry::make('address')
            ->label('Address'),

        SeparatorEntry::make('divider')
            ->thick()
            ->separatorColor('primary'),

        TextEntry::make('created_at')
            ->label('Member Since')
            ->date(),
    ]);
```

## Standalone Blade Component

Use the separator entry directly in Blade without the Infolist class:

```blade
{{-- Simple horizontal separator --}}
<x-infolist::separator-entry />

{{-- Dashed separator with text --}}
<x-infolist::separator-entry
    text="OR"
    style="dashed"
/>

{{-- Colored thick separator --}}
<x-infolist::separator-entry
    color="primary"
    thickness="thick"
/>

{{-- Separator with left-aligned text --}}
<x-infolist::separator-entry
    text="Section Title"
    textPosition="left"
    style="dotted"
/>

{{-- Vertical separator (for flex layouts) --}}
<x-infolist::separator-entry
    orientation="vertical"
    color="gray"
/>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `orientation` | string | 'horizontal' | Orientation: 'horizontal' or 'vertical' |
| `text` | string | null | Text to display in the middle |
| `textPosition` | string | 'center' | Text position: 'left', 'center', 'right' |
| `color` | string | 'gray' | Line color: primary, success, danger, warning, info, gray |
| `thickness` | string | 'thin' | Line thickness: 'thin', 'medium', 'thick' |
| `style` | string | 'solid' | Line style: 'solid', 'dashed', 'dotted' |

# Badge Entry

The BadgeEntry component displays values as styled badges with automatic color mapping based on state values.

## Basic Usage

```php
use Accelade\Infolists\Components\BadgeEntry;

BadgeEntry::make('status')
    ->label('Status'),
```

## Color Mapping

Map state values to specific colors:

```php
BadgeEntry::make('status')
    ->colors([
        'published' => 'success',
        'draft' => 'gray',
        'pending' => 'warning',
        'archived' => 'danger',
    ]),
```

Available colors: `primary`, `secondary`, `gray`, `success`, `danger`, `warning`, `info`

## Boolean Mode

Display boolean values as labeled badges:

```php
BadgeEntry::make('is_active')
    ->bool('Active', 'Inactive'),

// Automatically colors true as 'success' and false as 'danger'
```

## Default Color

Set a fallback color when no mapping matches:

```php
BadgeEntry::make('category')
    ->color('info'),
```

## With Icons

Add icons to badges:

```php
BadgeEntry::make('status')
    ->icon('heroicon-o-check-circle')
    ->iconPosition('before')
    ->colors([
        'published' => 'success',
    ]),

// Icon after text
BadgeEntry::make('priority')
    ->icon('heroicon-o-exclamation-triangle')
    ->iconPosition('after'),
```

## Icon Mapping

Map state values to specific icons:

```php
BadgeEntry::make('status')
    ->icons([
        'published' => 'heroicon-o-check-circle',
        'draft' => 'heroicon-o-pencil',
        'pending' => 'heroicon-o-clock',
    ])
    ->colors([
        'published' => 'success',
        'draft' => 'gray',
        'pending' => 'warning',
    ]),
```

## Tooltips

```php
BadgeEntry::make('status')
    ->tooltip(fn ($state) => "Current status: {$state}"),
```

## Visibility

```php
BadgeEntry::make('admin_badge')
    ->hidden(fn ($record) => ! $record->is_admin),
```

## Complete Example

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\BadgeEntry;

Infolist::make()
    ->record($post)
    ->columns(3)
    ->schema([
        BadgeEntry::make('status')
            ->label('Publication Status')
            ->colors([
                'published' => 'success',
                'draft' => 'gray',
                'scheduled' => 'info',
                'archived' => 'danger',
            ])
            ->icons([
                'published' => 'heroicon-o-check-circle',
                'draft' => 'heroicon-o-pencil',
                'scheduled' => 'heroicon-o-clock',
                'archived' => 'heroicon-o-archive-box',
            ]),

        BadgeEntry::make('is_featured')
            ->label('Featured')
            ->bool('Featured', 'Standard'),

        BadgeEntry::make('priority')
            ->label('Priority')
            ->colors([
                'high' => 'danger',
                'medium' => 'warning',
                'low' => 'info',
            ]),
    ]);
```

## Standalone Blade Component

Use the badge entry directly in Blade without the Infolist class:

```blade
<x-accelade::badge-entry
    label="Status"
    value="Published"
    color="success"
/>

<x-accelade::badge-entry
    label="Priority"
    value="High"
    color="danger"
    icon="heroicon-o-exclamation-triangle"
    iconPosition="before"
/>

<x-accelade::badge-entry
    label="Active"
    :value="true"
    :boolean="true"
    trueLabel="Active"
    falseLabel="Inactive"
/>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | mixed | null | The value to display |
| `label` | string | null | The label text |
| `helperText` | string | null | Helper text below the badge |
| `placeholder` | string | '-' | Placeholder when value is empty |
| `color` | string | 'primary' | Badge color: primary, secondary, gray, success, danger, warning, info |
| `icon` | string | null | Heroicon name |
| `iconPosition` | string | 'before' | Icon position: 'before' or 'after' |
| `boolean` | bool | false | Enable boolean mode |
| `trueLabel` | string | 'Yes' | Label for true value in boolean mode |
| `falseLabel` | string | 'No' | Label for false value in boolean mode |
| `trueColor` | string | 'success' | Color for true value |
| `falseColor` | string | 'danger' | Color for false value |
| `tooltip` | string | null | Tooltip text on hover |

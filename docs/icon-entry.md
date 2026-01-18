# Icon Entry

The IconEntry component displays icons, optionally based on boolean values.

## Basic Usage

```php
use Accelade\Infolists\Components\IconEntry;

IconEntry::make('status_icon')
    ->label('Status'),
```

## Custom Icon

Override the state with a specific icon:

```php
IconEntry::make('notification_type')
    ->icon('heroicon-o-bell'),
```

## Icon Size

```php
IconEntry::make('status')
    ->size('lg'),

// Available sizes: xs, sm, md, lg, xl, 2xl
```

## Icon Color

```php
IconEntry::make('status')
    ->color('success'),

IconEntry::make('priority')
    ->color(fn ($state) => match ($state) {
        'high' => 'danger',
        'medium' => 'warning',
        default => 'gray',
    }),
```

## Boolean Mode

Display different icons based on true/false values:

```php
IconEntry::make('is_active')
    ->boolean(),

// Custom icons for boolean states
IconEntry::make('is_verified')
    ->boolean()
    ->trueIcon('heroicon-o-check-badge')
    ->falseIcon('heroicon-o-x-circle'),

// Custom colors for boolean states
IconEntry::make('is_published')
    ->boolean()
    ->trueColor('success')
    ->falseColor('danger'),
```

## Tooltips

```php
IconEntry::make('status')
    ->tooltip(fn ($state) => "Status: {$state}"),
```

## Visibility

```php
IconEntry::make('admin_badge')
    ->hidden(fn ($record) => ! $record->is_admin),
```

## Complete Example

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\IconEntry;

Infolist::make()
    ->record($user)
    ->schema([
        IconEntry::make('email_verified_at')
            ->label('Email Verified')
            ->boolean()
            ->trueIcon('heroicon-o-check-circle')
            ->falseIcon('heroicon-o-x-circle')
            ->trueColor('success')
            ->falseColor('danger'),

        IconEntry::make('role')
            ->icon(fn ($state) => match ($state) {
                'admin' => 'heroicon-o-shield-check',
                'editor' => 'heroicon-o-pencil',
                default => 'heroicon-o-user',
            })
            ->color(fn ($state) => match ($state) {
                'admin' => 'danger',
                'editor' => 'warning',
                default => 'gray',
            }),
    ]);
```

## Standalone Blade Component

Use the icon entry directly in Blade without the Infolist class:

```blade
<x-infolist::icon-entry
    label="Status"
    icon="heroicon-o-check-circle"
    color="success"
/>

<x-infolist::icon-entry
    label="Email Verified"
    :value="true"
    :boolean="true"
    trueIcon="heroicon-o-check-circle"
    falseIcon="heroicon-o-x-circle"
    trueColor="success"
    falseColor="danger"
/>

<x-infolist::icon-entry
    label="Priority"
    icon="heroicon-o-exclamation-triangle"
    color="warning"
    size="lg"
    tooltip="High priority item"
/>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | mixed | null | The value (used in boolean mode) |
| `label` | string | null | The label text |
| `helperText` | string | null | Helper text below the icon |
| `placeholder` | string | '-' | Placeholder when no icon |
| `icon` | string | null | Heroicon name to display |
| `color` | string | 'gray' | Icon color |
| `size` | string | 'md' | Icon size: xs, sm, md, lg, xl, 2xl |
| `tooltip` | string | null | Tooltip text on hover |
| `boolean` | bool | false | Enable boolean mode |
| `trueIcon` | string | 'heroicon-o-check-circle' | Icon for true value |
| `falseIcon` | string | 'heroicon-o-x-circle' | Icon for false value |
| `trueColor` | string | 'success' | Color for true value |
| `falseColor` | string | 'danger' | Color for false value |

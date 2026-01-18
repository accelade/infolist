# Progress Entry

The ProgressEntry component displays numeric values as progress bars.

## Basic Usage

```php
use Accelade\Infolists\Components\ProgressEntry;

ProgressEntry::make('completion')
    ->label('Completion'),
```

## Min and Max Values

Set the range for the progress bar:

```php
ProgressEntry::make('score')
    ->min(0)
    ->max(100),  // Default

ProgressEntry::make('points')
    ->min(0)
    ->max(1000),
```

## Color

Set a fixed color or let it auto-color based on percentage:

```php
// Fixed color
ProgressEntry::make('progress')
    ->color('primary'),

ProgressEntry::make('storage_used')
    ->color('danger'),

// Auto-color based on percentage (default behavior)
// >= 80%: success (green)
// >= 50%: warning (yellow)
// >= 25%: info (blue)
// < 25%: danger (red)
ProgressEntry::make('completion'),
```

## Label

Show or hide the percentage label:

```php
// With label (default)
ProgressEntry::make('progress')
    ->showLabel(),

// Without label
ProgressEntry::make('progress')
    ->hideLabel(),
```

## Custom Label Format

Customize the label format:

```php
ProgressEntry::make('score')
    ->max(1000)
    ->labelFormat('{value} / {max} points'),

ProgressEntry::make('completion')
    ->labelFormat('{percentage}% complete'),
```

### Available Placeholders

- `{value}` - The current value
- `{min}` - The minimum value
- `{max}` - The maximum value
- `{percentage}` - The calculated percentage

## Bar Height

Adjust the height of the progress bar:

```php
ProgressEntry::make('progress')
    ->height('xs'),  // Extra small
ProgressEntry::make('progress')
    ->height('sm'),  // Small
ProgressEntry::make('progress')
    ->height('md'),  // Medium (default)
ProgressEntry::make('progress')
    ->height('lg'),  // Large
ProgressEntry::make('progress')
    ->height('xl'),  // Extra large
```

## Striped Style

Add stripes to the progress bar:

```php
ProgressEntry::make('downloading')
    ->striped(),
```

## Animated Style

Add animated stripes (automatically enables striped):

```php
ProgressEntry::make('processing')
    ->animated(),
```

## Complete Example

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\ProgressEntry;
use Accelade\Infolists\Components\TextEntry;

Infolist::make()
    ->record($project)
    ->schema([
        TextEntry::make('name')
            ->label('Project Name'),

        ProgressEntry::make('completion_percentage')
            ->label('Completion')
            ->height('lg')
            ->color('primary'),

        ProgressEntry::make('tasks_completed')
            ->label('Tasks')
            ->max(fn ($record) => $record->total_tasks)
            ->labelFormat('{value} of {max} tasks'),

        ProgressEntry::make('storage_used')
            ->label('Storage Used')
            ->max(fn ($record) => $record->storage_limit)
            ->labelFormat('{percentage}% ({value} GB)'),

        ProgressEntry::make('active_downloads')
            ->label('Downloading...')
            ->animated()
            ->color('info'),
    ]);
```

## Standalone Blade Component

Use the progress entry directly in Blade without the Infolist class:

```blade
<x-infolist::progress-entry
    label="Completion"
    :value="75"
/>

<x-infolist::progress-entry
    label="Storage Used"
    :value="80"
    color="danger"
    height="lg"
    :showLabel="true"
/>

<x-infolist::progress-entry
    label="Processing"
    :value="50"
    color="info"
    :striped="true"
    :animated="true"
/>

<x-infolist::progress-entry
    label="Points"
    :value="750"
    :min="0"
    :max="1000"
    color="success"
/>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | int/float | 0 | Current value |
| `label` | string | null | The label text |
| `helperText` | string | null | Helper text below the bar |
| `min` | int | 0 | Minimum value |
| `max` | int | 100 | Maximum value |
| `color` | string | null | Bar color (auto-colors if null) |
| `height` | string | 'md' | Bar height: xs, sm, md, lg, xl |
| `showLabel` | bool | true | Show percentage label |
| `striped` | bool | false | Add striped pattern |
| `animated` | bool | false | Animate stripes (enables striped) |

# Repeatable Entry

The RepeatableEntry component displays repeated data items with a nested schema.

## Basic Usage

```php
use Accelade\Infolists\Components\RepeatableEntry;
use Accelade\Infolists\Components\TextEntry;

RepeatableEntry::make('comments')
    ->schema([
        TextEntry::make('author'),
        TextEntry::make('content'),
        TextEntry::make('created_at')
            ->dateTime(),
    ]),
```

The state should be an array of items:

```php
[
    ['author' => 'John', 'content' => 'Great!', 'created_at' => '2024-01-15'],
    ['author' => 'Jane', 'content' => 'Thanks!', 'created_at' => '2024-01-16'],
]
```

## Contained Layout

Wrap each item in a bordered container:

```php
RepeatableEntry::make('orders')
    ->contained()
    ->schema([
        TextEntry::make('order_number'),
        TextEntry::make('total')
            ->money('USD'),
        TextEntry::make('status')
            ->badge(),
    ]),
```

## Grid Layout

Display items in a grid:

```php
RepeatableEntry::make('products')
    ->grid()
    ->gridColumns(3)
    ->schema([
        ImageEntry::make('image'),
        TextEntry::make('name'),
        TextEntry::make('price')
            ->money('USD'),
    ]),

// Available grid columns: 1, 2, 3, 4
```

## Placeholder

```php
RepeatableEntry::make('reviews')
    ->placeholder('No reviews yet')
    ->schema([...]),
```

## Nested Entries

Combine with other entry types:

```php
RepeatableEntry::make('team_members')
    ->contained()
    ->schema([
        ImageEntry::make('avatar')
            ->circular()
            ->size('lg'),

        TextEntry::make('name')
            ->weight('bold'),

        TextEntry::make('role')
            ->badge()
            ->color('primary'),

        TextEntry::make('email')
            ->icon('heroicon-o-envelope')
            ->copyable(),

        IconEntry::make('is_active')
            ->boolean(),
    ]),
```

## Complete Example

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\RepeatableEntry;
use Accelade\Infolists\Components\TextEntry;
use Accelade\Infolists\Components\ImageEntry;
use Accelade\Infolists\Components\IconEntry;

Infolist::make()
    ->record($project)
    ->schema([
        TextEntry::make('name')
            ->size('xl')
            ->weight('bold'),

        TextEntry::make('description')
            ->columnSpanFull(),

        RepeatableEntry::make('milestones')
            ->label('Project Milestones')
            ->contained()
            ->schema([
                TextEntry::make('title')
                    ->weight('semibold'),

                TextEntry::make('due_date')
                    ->date(),

                TextEntry::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'completed' => 'success',
                        'in_progress' => 'warning',
                        default => 'gray',
                    }),

                TextEntry::make('description')
                    ->limit(100),
            ]),

        RepeatableEntry::make('contributors')
            ->label('Contributors')
            ->grid()
            ->gridColumns(4)
            ->schema([
                ImageEntry::make('avatar')
                    ->circular()
                    ->size('lg'),

                TextEntry::make('name')
                    ->size('sm'),
            ]),
    ]);
```

## Standalone Blade Component

Use the repeatable entry directly in Blade without the Infolist class. Note that standalone mode uses a slot for content instead of a schema:

```blade
{{-- Basic repeatable with items --}}
@php
$comments = [
    ['author' => 'John', 'content' => 'Great post!'],
    ['author' => 'Jane', 'content' => 'Thanks for sharing!'],
];
@endphp

<x-infolist::repeatable-entry
    label="Comments"
    :items="$comments"
>
    {{-- Content rendered for each item --}}
    <div class="flex gap-2">
        <span class="font-medium">Author Name</span>
        <span class="text-gray-500">Comment content</span>
    </div>
</x-infolist::repeatable-entry>

{{-- Contained layout --}}
<x-infolist::repeatable-entry
    label="Orders"
    :items="$orders"
    :contained="true"
>
    <div class="flex items-center justify-between">
        <span>Order details here</span>
    </div>
</x-infolist::repeatable-entry>

{{-- Grid layout --}}
<x-infolist::repeatable-entry
    label="Team Members"
    :items="$members"
    :grid="true"
    :gridColumns="3"
>
    <div class="text-center">
        <div class="font-medium">Member Name</div>
    </div>
</x-infolist::repeatable-entry>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `items` | array | [] | Array of items to iterate over |
| `label` | string | null | The label text |
| `helperText` | string | null | Helper text below the list |
| `placeholder` | string | 'No items' | Placeholder when no items |
| `contained` | bool | false | Wrap each item in a bordered card |
| `grid` | bool | false | Display items in a grid layout |
| `simple` | bool | false | Compact horizontal list layout |
| `gridColumns` | int | 1 | Number of grid columns (1-6) |

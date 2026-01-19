# Rating Entry

The RatingEntry component displays numeric ratings as visual icons like stars or hearts.

## Basic Usage

```php
use Accelade\Infolists\Components\RatingEntry;

RatingEntry::make('rating')
    ->label('Customer Rating'),
```

## Star Ratings

Display ratings with star icons (default):

```php
RatingEntry::make('rating')
    ->stars()
    ->label('Rating'),

// Custom max value
RatingEntry::make('rating')
    ->stars(10)  // 10-star scale
    ->label('Rating out of 10'),
```

## Heart Ratings

Display ratings with heart icons:

```php
RatingEntry::make('popularity')
    ->hearts()
    ->label('Popularity'),

// Custom max value
RatingEntry::make('score')
    ->hearts(3)  // 3-heart scale
    ->label('Score'),
```

## Half Stars

Allow half-filled icons for decimal ratings:

```php
RatingEntry::make('rating')
    ->stars()
    ->allowHalf()  // Shows 4.5 as 4 full + 1 half star
    ->label('Rating'),
```

## Max Value

Set the maximum rating value:

```php
RatingEntry::make('stars')
    ->max(10),
```

## Custom Icons

Use custom icons:

```php
RatingEntry::make('score')
    ->filledIcon('heroicon-s-check-circle')
    ->emptyIcon('heroicon-o-x-circle'),
```

## Colors

Customize filled and empty colors:

```php
RatingEntry::make('rating')
    ->stars()
    ->filledColor('success')   // Green filled stars
    ->emptyColor('gray'),      // Gray empty stars

// Available colors: primary, secondary, gray, success, danger, warning, info
```

## Size

Adjust the icon size:

```php
RatingEntry::make('rating')
    ->ratingSize('xs'),  // Extra small
RatingEntry::make('rating')
    ->ratingSize('sm'),  // Small
RatingEntry::make('rating')
    ->ratingSize('md'),  // Medium (default)
RatingEntry::make('rating')
    ->ratingSize('lg'),  // Large
RatingEntry::make('rating')
    ->ratingSize('xl'),  // Extra large
```

## Complete Example

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\RatingEntry;
use Accelade\Infolists\Components\TextEntry;

Infolist::make()
    ->record($review)
    ->schema([
        TextEntry::make('reviewer_name')
            ->label('Reviewer'),

        RatingEntry::make('overall_rating')
            ->stars()
            ->allowHalf()
            ->ratingSize('lg')
            ->label('Overall Rating'),

        RatingEntry::make('quality_score')
            ->stars()
            ->filledColor('primary')
            ->label('Quality'),

        RatingEntry::make('value_score')
            ->stars()
            ->filledColor('success')
            ->label('Value for Money'),

        RatingEntry::make('popularity')
            ->hearts(5)
            ->ratingSize('sm')
            ->label('Popularity'),
    ]);
```

## Standalone Blade Component

Use the rating entry directly in Blade without the Infolist class:

```blade
<x-accelade::rating-entry
    label="Rating"
    :value="4"
/>

<x-accelade::rating-entry
    label="Customer Rating"
    :value="4.5"
    :max="5"
    :allowHalf="true"
    size="lg"
    filledColor="warning"
/>

<x-accelade::rating-entry
    label="Popularity"
    :value="3"
    :max="5"
    filledIcon="heroicon-s-heart"
    emptyIcon="heroicon-o-heart"
    filledColor="danger"
/>

<x-accelade::rating-entry
    label="Score"
    :value="8"
    :max="10"
    :showNumeric="true"
/>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | int/float | 0 | Rating value |
| `label` | string | null | The label text |
| `helperText` | string | null | Helper text below the rating |
| `max` | int | 5 | Maximum rating value |
| `filledIcon` | string | 'heroicon-s-star' | Icon for filled state |
| `emptyIcon` | string | 'heroicon-o-star' | Icon for empty state |
| `filledColor` | string | 'warning' | Color for filled icons |
| `emptyColor` | string | 'gray' | Color for empty icons |
| `size` | string | 'md' | Icon size: xs, sm, md, lg, xl |
| `allowHalf` | bool | false | Allow half-filled icons |
| `showNumeric` | bool | false | Show numeric value alongside icons |

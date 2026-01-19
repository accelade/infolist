# Getting Started

Accelade Infolist provides a powerful way to display read-only information in a structured, consistent manner. It follows the Filament infolist API for familiarity and ease of use.

## Installation

```bash
composer require accelade/infolists
```

The package auto-registers its service provider via Laravel's package discovery.

## Quick Start

### Basic Usage

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\TextEntry;

$infolist = Infolist::make()
    ->record($user)
    ->schema([
        TextEntry::make('name'),
        TextEntry::make('email'),
        TextEntry::make('created_at')
            ->dateTime(),
    ]);
```

### Rendering in Blade

```blade
<x-accelade::infolist :infolist="$infolist" />
```

Or render directly:

```blade
{!! $infolist->toHtml() !!}
```

## Available Entries

- **TextEntry** - Display text, numbers, dates, markdown, and more
- **IconEntry** - Display icons with optional boolean mode
- **ImageEntry** - Display single or multiple images
- **ColorEntry** - Display color swatches
- **KeyValueEntry** - Display key-value pairs in a table
- **RepeatableEntry** - Display repeating data with nested schema

## Core Concepts

### Records

Infolists display data from a record - typically an Eloquent model or array:

```php
Infolist::make()
    ->record($user)
    ->schema([...]);
```

### Entry Names

Entry names correspond to attributes on the record. Dot notation is supported for nested data:

```php
TextEntry::make('profile.bio'),
TextEntry::make('address.city'),
```

### Labels

Labels are auto-generated from the entry name but can be customized:

```php
TextEntry::make('created_at')
    ->label('Member Since'),
```

### Column Layout

Control grid layout with columns:

```php
Infolist::make()
    ->columns(3)
    ->schema([
        TextEntry::make('name')
            ->columnSpan(2),
        TextEntry::make('status'),
    ]);
```

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=infolists-config
```

Key configuration options:

```php
return [
    'placeholder' => '—',
    'copy_message' => 'Copied!',
    'copy_message_duration' => 2000,
];
```

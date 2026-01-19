# Key Value Entry

The KeyValueEntry component displays associative arrays as a formatted table.

## Basic Usage

```php
use Accelade\Infolists\Components\KeyValueEntry;

KeyValueEntry::make('metadata')
    ->label('Metadata'),
```

The state should be an associative array:

```php
[
    'version' => '1.0.0',
    'author' => 'John Doe',
    'license' => 'MIT',
]
```

## Custom Labels

Customize the column headers:

```php
KeyValueEntry::make('settings')
    ->keyLabel('Setting')
    ->valueLabel('Current Value'),
```

## Placeholder

```php
KeyValueEntry::make('custom_fields')
    ->placeholder('No custom fields defined'),
```

## Visibility

```php
KeyValueEntry::make('debug_info')
    ->hidden(fn () => ! config('app.debug')),
```

## Complete Example

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\KeyValueEntry;
use Accelade\Infolists\Components\TextEntry;

Infolist::make()
    ->record($package)
    ->schema([
        TextEntry::make('name')
            ->label('Package Name'),

        KeyValueEntry::make('composer_info')
            ->label('Composer Details')
            ->keyLabel('Property')
            ->valueLabel('Value'),

        KeyValueEntry::make('requirements')
            ->label('Dependencies')
            ->keyLabel('Package')
            ->valueLabel('Version'),

        KeyValueEntry::make('scripts')
            ->label('NPM Scripts')
            ->keyLabel('Command')
            ->valueLabel('Script'),
    ]);
```

## Nested Values

The component handles nested arrays and objects:

```php
// This data:
[
    'simple' => 'value',
    'nested' => ['a' => 1, 'b' => 2],
    'boolean' => true,
    'null_value' => null,
]

// Will be displayed with nested values as formatted JSON
```

## Standalone Blade Component

Use the key-value entry directly in Blade without the Infolist class:

```blade
<x-accelade::key-value-entry
    label="Server Info"
    :value="['PHP Version' => '8.3', 'Laravel' => '12.0', 'OS' => 'Ubuntu 22.04']"
    keyLabel="Property"
    valueLabel="Value"
/>

<x-accelade::key-value-entry
    label="Package Dependencies"
    :value="['laravel/framework' => '^12.0', 'php' => '>=8.2']"
    keyLabel="Package"
    valueLabel="Version"
/>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | array | null | Associative array of key-value pairs |
| `label` | string | null | The label text |
| `helperText` | string | null | Helper text below the table |
| `placeholder` | string | '-' | Placeholder when no value |
| `keyLabel` | string | 'Key' | Column header for keys |
| `valueLabel` | string | 'Value' | Column header for values |

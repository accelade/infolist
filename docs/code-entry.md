# Code Entry

The CodeEntry component displays code snippets with syntax highlighting, line numbers, and copy functionality.

## Basic Usage

```php
use Accelade\Infolists\Components\CodeEntry;

CodeEntry::make('source_code')
    ->label('Source Code'),
```

## Language

Set the syntax language for highlighting:

```php
CodeEntry::make('code')
    ->language('php'),
```

### Language Shortcuts

Use convenience methods for common languages:

```php
CodeEntry::make('code')->php(),
CodeEntry::make('config')->json(),
CodeEntry::make('script')->javascript(),
CodeEntry::make('types')->typescript(),
CodeEntry::make('script')->python(),
CodeEntry::make('query')->sql(),
CodeEntry::make('config')->yaml(),
CodeEntry::make('template')->html(),
CodeEntry::make('styles')->css(),
CodeEntry::make('script')->bash(),
CodeEntry::make('template')->blade(),
```

## Line Numbers

Toggle line numbers display:

```php
// With line numbers (default)
CodeEntry::make('code')
    ->php()
    ->lineNumbers(),

// Without line numbers
CodeEntry::make('code')
    ->sql()
    ->lineNumbers(false),
```

## Max Height

Limit the height of the code block with scrolling:

```php
CodeEntry::make('long_script')
    ->bash()
    ->maxHeight(200), // 200px max height
```

## Copy Button

Toggle the copy-to-clipboard button:

```php
// With copy button (default)
CodeEntry::make('api_key')
    ->copyable(),

// Without copy button
CodeEntry::make('example')
    ->html()
    ->copyable(false),
```

## JSON Data

Arrays and objects are automatically formatted as pretty JSON:

```php
CodeEntry::make('config')
    ->json()
    ->label('Configuration'),

// If the state is an array:
// ['name' => 'John', 'roles' => ['admin']]
// It will be displayed as formatted JSON
```

## Tooltips

```php
CodeEntry::make('script')
    ->tooltip('Click the clipboard icon to copy'),
```

## Visibility

```php
CodeEntry::make('debug_info')
    ->hidden(fn () => ! config('app.debug')),
```

## Complete Example

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\CodeEntry;

Infolist::make()
    ->record($deployment)
    ->columns(1)
    ->schema([
        CodeEntry::make('deploy_script')
            ->label('Deployment Script')
            ->bash()
            ->lineNumbers()
            ->maxHeight(300),

        CodeEntry::make('environment_config')
            ->label('Environment Variables')
            ->json()
            ->copyable(),

        CodeEntry::make('last_query')
            ->label('Database Query')
            ->sql()
            ->lineNumbers(false),
    ]);
```

## Standalone Blade Component

Use the code entry directly in Blade without the Infolist class:

```blade
<x-infolist::code-entry
    label="Configuration"
    value="return ['debug' => true, 'cache' => 'redis'];"
    language="php"
/>

<x-infolist::code-entry
    label="API Response"
    :value="['name' => 'John', 'email' => 'john@example.com']"
    language="json"
/>

<x-infolist::code-entry
    label="SQL Query"
    value="SELECT * FROM users WHERE active = 1;"
    language="sql"
    :maxHeight="200"
/>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string/array | null | Code to display (arrays auto-format as JSON) |
| `label` | string | null | The label text |
| `helperText` | string | null | Helper text below the code |
| `placeholder` | string | '-' | Placeholder when no value |
| `language` | string | 'text' | Syntax language: php, json, javascript, sql, bash, html, css, etc. |
| `maxHeight` | int | null | Maximum height in pixels (scrollable) |
| `tooltip` | string | null | Tooltip text on hover |

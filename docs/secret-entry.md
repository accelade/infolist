# Secret Entry

The SecretEntry component displays sensitive data that is masked by default and can be revealed on demand.

## Basic Usage

```php
use Accelade\Infolists\Components\SecretEntry;

SecretEntry::make('api_key')
    ->label('API Key'),
```

## Mask

Customize the mask character or string:

```php
SecretEntry::make('password')
    ->mask('••••••••'),

SecretEntry::make('token')
    ->mask('*'.repeat(16)),
```

## Visible Characters

Show some characters of the actual value:

### Show Last Characters

```php
SecretEntry::make('api_key')
    ->showLast(4),  // Shows: ********abcd
```

### Show First Characters

```php
SecretEntry::make('card_number')
    ->showFirst(4),  // Shows: 4242********
```

## Reveal Behavior

### Reveal on Click (Default)

```php
SecretEntry::make('password')
    ->revealOnClick(),
```

### Reveal on Hover

```php
SecretEntry::make('token')
    ->revealOnHover(),
```

### Disable Reveal

```php
SecretEntry::make('password')
    ->revealOnClick(false)
    ->revealOnHover(false),
```

## Auto-Hide

Automatically hide the value after a delay:

```php
SecretEntry::make('otp')
    ->autoHideAfter(5),  // Hides after 5 seconds
```

## Custom Icons

Customize the reveal/hide toggle icons:

```php
SecretEntry::make('password')
    ->revealIcon('heroicon-o-eye')
    ->hideIcon('heroicon-o-eye-slash'),

SecretEntry::make('password')
    ->revealIcon('heroicon-o-lock-open')
    ->hideIcon('heroicon-o-lock-closed'),
```

## Complete Example

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\SecretEntry;
use Accelade\Infolists\Components\TextEntry;

Infolist::make()
    ->record($user)
    ->schema([
        TextEntry::make('email')
            ->label('Email'),

        SecretEntry::make('api_key')
            ->label('API Key')
            ->showLast(4)
            ->autoHideAfter(10),

        SecretEntry::make('webhook_secret')
            ->label('Webhook Secret')
            ->mask('sk_live_••••••••')
            ->revealOnClick(),

        SecretEntry::make('password_hash')
            ->label('Password Hash')
            ->revealOnHover()
            ->showFirst(8),

        SecretEntry::make('two_factor_recovery')
            ->label('Recovery Codes')
            ->revealIcon('heroicon-o-shield-check')
            ->hideIcon('heroicon-o-shield-exclamation'),
    ]);
```

## Security Considerations

- The actual value is still sent to the client, just hidden visually
- For truly sensitive data, consider not displaying it at all
- Use `autoHideAfter()` to reduce exposure time
- Consider using `revealOnClick()` instead of `revealOnHover()` for more intentional reveals

## Standalone Blade Component

Use the secret entry directly in Blade without the Infolist class:

```blade
<x-accelade::secret-entry
    label="API Key"
    value="sk_live_abc123xyz789"
/>

<x-accelade::secret-entry
    label="Password"
    value="supersecret123"
    :revealOnHover="true"
    :revealOnClick="false"
/>

<x-accelade::secret-entry
    label="Token"
    value="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"
    :autoHideAfter="5"
    maskCharacter="•"
    :maskLength="16"
/>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string | null | The secret value |
| `label` | string | null | The label text |
| `helperText` | string | null | Helper text below the value |
| `maskCharacter` | string | '•' | Character used for masking |
| `maskLength` | int | 12 | Number of mask characters to show |
| `revealOnHover` | bool | false | Reveal value on hover |
| `revealOnClick` | bool | true | Reveal value on click |
| `autoHideAfter` | int | null | Auto-hide after N seconds |

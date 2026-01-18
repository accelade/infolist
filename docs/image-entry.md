# Image Entry

The ImageEntry component displays single or multiple images with various styling options.

## Basic Usage

```php
use Accelade\Infolists\Components\ImageEntry;

ImageEntry::make('avatar')
    ->label('Profile Picture'),
```

## Image Size

```php
ImageEntry::make('avatar')
    ->size('lg'),

// Available sizes: xs, sm, md, lg, xl, 2xl
```

## Custom Dimensions

```php
ImageEntry::make('banner')
    ->width(300)
    ->height(100),
```

## Circular Images

Perfect for avatars:

```php
ImageEntry::make('avatar')
    ->circular(),
```

## Square Images

```php
ImageEntry::make('thumbnail')
    ->square(),
```

## Multiple Images

Display an array of images:

```php
ImageEntry::make('photos')
    ->label('Gallery'),
```

## Stacked Images

Stack multiple images with overlap:

```php
ImageEntry::make('team_members.*.avatar')
    ->stacked(),
```

## Stack Limit

Limit visible images and show remaining count:

```php
ImageEntry::make('participants.*.photo')
    ->stacked()
    ->limit(5), // Shows +N for remaining
```

## Custom Remaining Count

```php
ImageEntry::make('attendees')
    ->stacked()
    ->limit(3)
    ->remainingCount(10), // Override automatic count
```

## URLs

Link images:

```php
ImageEntry::make('photo')
    ->url(fn ($record) => route('photos.show', $record)),

ImageEntry::make('avatar')
    ->url(fn ($record) => $record->profile_url)
    ->openUrlInNewTab(),
```

## Tooltips

```php
ImageEntry::make('avatar')
    ->tooltip(fn ($record) => $record->name),
```

## Visibility

```php
ImageEntry::make('private_photo')
    ->hidden(fn ($record) => ! $record->show_photo),
```

## Lazy Loading

Images are lazy loaded by default for better performance:

```php
// Lazy loading is enabled by default
ImageEntry::make('photo')
    ->lazy(),

// Disable lazy loading for above-the-fold images
ImageEntry::make('hero')
    ->eager(),

// Or set loading attribute explicitly
ImageEntry::make('image')
    ->loading('auto'),
```

## Picture Tag for Responsive Images

Use the `<picture>` tag for art direction and format switching:

```php
ImageEntry::make('hero')
    ->picture()
    ->sources([
        ['srcset' => '/images/hero-mobile.webp', 'media' => '(max-width: 768px)', 'type' => 'image/webp'],
        ['srcset' => '/images/hero-mobile.jpg', 'media' => '(max-width: 768px)'],
        ['srcset' => '/images/hero-desktop.webp', 'type' => 'image/webp'],
        ['srcset' => '/images/hero-desktop.jpg'],
    ]),
```

## Alt Text

Set accessible alt text for images:

```php
ImageEntry::make('product_image')
    ->alt(fn ($record) => $record->product_name),
```

## Complete Example

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\ImageEntry;

Infolist::make()
    ->record($team)
    ->schema([
        ImageEntry::make('logo')
            ->label('Team Logo')
            ->size('xl')
            ->circular(),

        ImageEntry::make('members.*.avatar')
            ->label('Team Members')
            ->stacked()
            ->circular()
            ->limit(5)
            ->size('md'),

        ImageEntry::make('cover_photo')
            ->label('Cover Photo')
            ->width(400)
            ->height(200),
    ]);
```

## Standalone Blade Component

Use the image entry directly in Blade without the Infolist class:

```blade
<x-infolist::image-entry
    label="Avatar"
    value="/images/avatar.jpg"
    :circular="true"
    size="lg"
/>

<x-infolist::image-entry
    label="Product Photo"
    value="/images/product.jpg"
    :square="true"
    :width="200"
    :height="200"
/>

<x-infolist::image-entry
    label="Team Members"
    :value="['/img/user1.jpg', '/img/user2.jpg', '/img/user3.jpg']"
    :stacked="true"
    :stackLimit="3"
    :circular="true"
/>
```

### Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string/array | null | Image URL or array of URLs |
| `label` | string | null | The label text |
| `helperText` | string | null | Helper text below the image |
| `placeholder` | string | '-' | Placeholder when no image |
| `circular` | bool | false | Display as circle (for avatars) |
| `square` | bool | false | Display as square |
| `size` | string | 'md' | Preset size: xs, sm, md, lg, xl, 2xl |
| `width` | int | null | Custom width in pixels |
| `height` | int | null | Custom height in pixels |
| `stacked` | bool | false | Stack multiple images with overlap |
| `stackLimit` | int | 3 | Max visible images when stacked |
| `tooltip` | string | null | Tooltip text on hover |
| `url` | string | null | Link URL when clicked |
| `openUrlInNewTab` | bool | false | Open link in new tab |
| `loading` | string | 'lazy' | Loading attribute: lazy, eager, auto |
| `picture` | bool | false | Use picture tag for responsive images |
| `sources` | array | [] | Sources for picture tag |
| `alt` | string | '' | Alt text for accessibility |

@php
    use Accelade\Infolists\Infolist;
    use Accelade\Infolists\Components\MarkdownEntry;

    // Sample markdown content
    $basicMarkdown = <<<'MD'
This is a **bold** statement and this is *italic* text.

Here's a [link to somewhere](#) and some `inline code`.
MD;

    $headingsMarkdown = <<<'MD'
# Heading 1
## Heading 2
### Heading 3
#### Heading 4
##### Heading 5
###### Heading 6
MD;

    $listsMarkdown = <<<'MD'
## Unordered List
- First item
- Second item
  - Nested item
  - Another nested
- Third item

## Ordered List
1. Step one
2. Step two
3. Step three

## Task List
- [x] Completed task
- [ ] Pending task
- [ ] Another task
MD;

    $codeMarkdown = <<<'MD'
Inline `code` looks like this.

```php
<?php

class Example
{
    public function hello(): string
    {
        return 'Hello, World!';
    }
}
```

```javascript
const greeting = () => {
    console.log('Hello from JS!');
};
```
MD;

    $tableMarkdown = <<<'MD'
| Feature | Status | Notes |
|---------|--------|-------|
| Markdown | ✅ | Full support |
| Tables | ✅ | GFM style |
| Code | ✅ | Syntax highlighting |
| Images | ✅ | Responsive |
MD;

    $blockquoteMarkdown = <<<'MD'
> This is a blockquote.
>
> It can span multiple lines and contain **formatted** text.

---

Regular text after a horizontal rule.
MD;

    $longMarkdown = <<<'MD'
# Getting Started Guide

Welcome to the getting started guide. This document will walk you through the initial setup and configuration.

## Installation

First, install the package using Composer:

```bash
composer require accelade/infolist
```

## Configuration

After installation, publish the configuration file:

```bash
php artisan vendor:publish --tag=infolist-config
```

## Basic Usage

Create your first infolist:

```php
use Accelade\Infolists\Infolist;
use Accelade\Infolists\Components\TextEntry;

$infolist = Infolist::make()
    ->record($user)
    ->schema([
        TextEntry::make('name'),
        TextEntry::make('email'),
    ]);
```

## Advanced Features

The package includes many advanced features:
- Custom styling
- Responsive layouts
- Dark mode support
- Accessibility features

## Next Steps

Continue reading the documentation to learn more about:
1. Entry components
2. Layouts and sections
3. Customization options
4. Best practices
MD;

    // Basic markdown
    $basicInfolist = Infolist::make()
        ->record(['content' => $basicMarkdown])
        ->schema([
            MarkdownEntry::make('content')
                ->label('Basic Formatting'),
        ]);

    // Headings
    $headingsInfolist = Infolist::make()
        ->record(['content' => $headingsMarkdown])
        ->schema([
            MarkdownEntry::make('content')
                ->label('Heading Levels'),
        ]);

    // Lists
    $listsInfolist = Infolist::make()
        ->record(['content' => $listsMarkdown])
        ->schema([
            MarkdownEntry::make('content')
                ->label('Lists & Tasks'),
        ]);

    // Code blocks
    $codeInfolist = Infolist::make()
        ->record(['content' => $codeMarkdown])
        ->schema([
            MarkdownEntry::make('content')
                ->label('Code Blocks'),
        ]);

    // Tables
    $tableInfolist = Infolist::make()
        ->record(['content' => $tableMarkdown])
        ->schema([
            MarkdownEntry::make('content')
                ->label('Tables'),
        ]);

    // Blockquotes
    $blockquoteInfolist = Infolist::make()
        ->record(['content' => $blockquoteMarkdown])
        ->schema([
            MarkdownEntry::make('content')
                ->label('Blockquotes & Dividers'),
        ]);

    // Max height with scrolling
    $scrollInfolist = Infolist::make()
        ->record(['content' => $longMarkdown])
        ->schema([
            MarkdownEntry::make('content')
                ->label('Scrollable Content')
                ->maxHeight('250px'),
        ]);

    // Collapsible content
    $collapsibleInfolist = Infolist::make()
        ->record(['content' => $longMarkdown])
        ->schema([
            MarkdownEntry::make('content')
                ->label('Collapsible Content')
                ->collapsible()
                ->collapsed(),
        ]);
@endphp

<div class="space-y-8">
    {{-- Basic Formatting --}}
    <div class="rounded-xl shadow-sm overflow-hidden" style="background: var(--docs-bg, #ffffff); border: 1px solid var(--docs-border, #e2e8f0);">
        <div class="px-6 py-4" style="background: var(--docs-bg-alt, #f8fafc); border-bottom: 1px solid var(--docs-border, #e2e8f0);">
            <h3 class="text-base font-semibold" style="color: var(--docs-text, #0f172a);">Basic Formatting</h3>
            <p class="mt-1 text-sm" style="color: var(--docs-text-muted, #64748b);">Bold, italic, links, and inline code</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$basicInfolist" />
        </div>
    </div>

    {{-- Headings --}}
    <div class="rounded-xl shadow-sm overflow-hidden" style="background: var(--docs-bg, #ffffff); border: 1px solid var(--docs-border, #e2e8f0);">
        <div class="px-6 py-4" style="background: var(--docs-bg-alt, #f8fafc); border-bottom: 1px solid var(--docs-border, #e2e8f0);">
            <h3 class="text-base font-semibold" style="color: var(--docs-text, #0f172a);">Heading Levels</h3>
            <p class="mt-1 text-sm" style="color: var(--docs-text-muted, #64748b);">All six heading levels with proper styling</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$headingsInfolist" />
        </div>
    </div>

    {{-- Lists --}}
    <div class="rounded-xl shadow-sm overflow-hidden" style="background: var(--docs-bg, #ffffff); border: 1px solid var(--docs-border, #e2e8f0);">
        <div class="px-6 py-4" style="background: var(--docs-bg-alt, #f8fafc); border-bottom: 1px solid var(--docs-border, #e2e8f0);">
            <h3 class="text-base font-semibold" style="color: var(--docs-text, #0f172a);">Lists & Task Lists</h3>
            <p class="mt-1 text-sm" style="color: var(--docs-text-muted, #64748b);">Ordered, unordered, nested, and task lists</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$listsInfolist" />
        </div>
    </div>

    {{-- Code Blocks --}}
    <div class="rounded-xl shadow-sm overflow-hidden" style="background: var(--docs-bg, #ffffff); border: 1px solid var(--docs-border, #e2e8f0);">
        <div class="px-6 py-4" style="background: var(--docs-bg-alt, #f8fafc); border-bottom: 1px solid var(--docs-border, #e2e8f0);">
            <h3 class="text-base font-semibold" style="color: var(--docs-text, #0f172a);">Code Blocks</h3>
            <p class="mt-1 text-sm" style="color: var(--docs-text-muted, #64748b);">Inline code and fenced code blocks</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$codeInfolist" />
        </div>
    </div>

    {{-- Tables --}}
    <div class="rounded-xl shadow-sm overflow-hidden" style="background: var(--docs-bg, #ffffff); border: 1px solid var(--docs-border, #e2e8f0);">
        <div class="px-6 py-4" style="background: var(--docs-bg-alt, #f8fafc); border-bottom: 1px solid var(--docs-border, #e2e8f0);">
            <h3 class="text-base font-semibold" style="color: var(--docs-text, #0f172a);">Tables</h3>
            <p class="mt-1 text-sm" style="color: var(--docs-text-muted, #64748b);">GitHub-flavored markdown tables with zebra striping</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$tableInfolist" />
        </div>
    </div>

    {{-- Blockquotes --}}
    <div class="rounded-xl shadow-sm overflow-hidden" style="background: var(--docs-bg, #ffffff); border: 1px solid var(--docs-border, #e2e8f0);">
        <div class="px-6 py-4" style="background: var(--docs-bg-alt, #f8fafc); border-bottom: 1px solid var(--docs-border, #e2e8f0);">
            <h3 class="text-base font-semibold" style="color: var(--docs-text, #0f172a);">Blockquotes & Dividers</h3>
            <p class="mt-1 text-sm" style="color: var(--docs-text-muted, #64748b);">Blockquotes and horizontal rules</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$blockquoteInfolist" />
        </div>
    </div>

    {{-- Scrollable Content --}}
    <div class="rounded-xl shadow-sm overflow-hidden" style="background: var(--docs-bg, #ffffff); border: 1px solid var(--docs-border, #e2e8f0);">
        <div class="px-6 py-4" style="background: var(--docs-bg-alt, #f8fafc); border-bottom: 1px solid var(--docs-border, #e2e8f0);">
            <h3 class="text-base font-semibold" style="color: var(--docs-text, #0f172a);">Scrollable Content</h3>
            <p class="mt-1 text-sm" style="color: var(--docs-text-muted, #64748b);">Long content with max-height and scrolling</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$scrollInfolist" />
        </div>
    </div>

    {{-- Collapsible Content --}}
    <div class="rounded-xl shadow-sm overflow-hidden" style="background: var(--docs-bg, #ffffff); border: 1px solid var(--docs-border, #e2e8f0);">
        <div class="px-6 py-4" style="background: var(--docs-bg-alt, #f8fafc); border-bottom: 1px solid var(--docs-border, #e2e8f0);">
            <h3 class="text-base font-semibold" style="color: var(--docs-text, #0f172a);">Collapsible Content</h3>
            <p class="mt-1 text-sm" style="color: var(--docs-text-muted, #64748b);">Content that can be expanded/collapsed</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$collapsibleInfolist" />
        </div>
    </div>

    {{-- Standalone Blade Component --}}
    <div class="rounded-xl shadow-sm overflow-hidden" style="background: var(--docs-bg, #ffffff); border: 1px solid var(--docs-border, #e2e8f0);">
        <div class="px-6 py-4" style="background: var(--docs-bg-alt, #f8fafc); border-bottom: 1px solid var(--docs-border, #e2e8f0);">
            <h3 class="text-base font-semibold" style="color: var(--docs-text, #0f172a);">Standalone Blade Component</h3>
            <p class="mt-1 text-sm" style="color: var(--docs-text-muted, #64748b);">Use directly in Blade without Infolist class</p>
        </div>
        <div class="p-6">
            <div class="space-y-6">
                <x-infolists::markdown-entry
                    label="Quick Example"
                    value="This is **bold** and *italic* with a [link](#)."
                />

                <x-infolists::markdown-entry
                    label="With Code"
                    value="Use `composer require accelade/infolist` to install."
                />
            </div>
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">&lt;!-- Basic usage --&gt;
&lt;x-infolists::markdown-entry
    label="Description"
    :value="$markdownContent"
/&gt;

&lt;!-- With max height --&gt;
&lt;x-infolists::markdown-entry
    label="Documentation"
    :value="$docs"
    maxHeight="300px"
/&gt;

&lt;!-- Collapsible --&gt;
&lt;x-infolists::markdown-entry
    label="README"
    :value="$readme"
    :collapsible="true"
    :collapsed="true"
/&gt;</x-accelade::code-block>
        </div>
    </div>
</div>

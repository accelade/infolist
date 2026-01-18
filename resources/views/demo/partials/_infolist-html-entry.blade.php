@php
    use Accelade\Infolist\Infolist;
    use Accelade\Infolist\Components\HtmlEntry;

    $data = [
        'html_content' => '<div><h2>Welcome!</h2><p>This is <strong>HTML</strong> content with <em>formatting</em>.</p><ul><li>Item 1</li><li>Item 2</li></ul></div>',
        'markdown_content' => "## Hello World\n\nThis is **Markdown** content with *formatting*.\n\n- Item 1\n- Item 2\n- Item 3\n\n> This is a blockquote.\n\n```php\n\$variable = 'Hello';\n```",
        'article' => '<article><h1>Article Title</h1><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p></article>',
        'long_content' => "# Long Content\n\n" . str_repeat("Lorem ipsum dolor sit amet, consectetur adipiscing elit. ", 20),
    ];

    // Basic HTML
    $htmlInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            HtmlEntry::make('html_content')
                ->label('HTML Content')
                ->html(),
        ]);

    // Markdown
    $markdownInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            HtmlEntry::make('markdown_content')
                ->label('Markdown Content')
                ->markdown(),
        ]);

    // With Prose Styling
    $proseInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            HtmlEntry::make('article')
                ->label('Article with Prose')
                ->html()
                ->prose(),
        ]);

    // Without Prose
    $noProseInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            HtmlEntry::make('article')
                ->label('Article without Prose')
                ->html()
                ->prose(false),
        ]);

    // Max Height
    $maxHeightInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            HtmlEntry::make('long_content')
                ->label('Scrollable Content (200px max)')
                ->markdown()
                ->maxHeight('200px'),
        ]);
@endphp

<div class="space-y-8">
    {{-- Basic HTML --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">HTML Content</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Raw HTML rendered directly</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$htmlInfolist" />
        </div>
    </div>

    {{-- Markdown --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Markdown Content</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Markdown converted to HTML</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$markdownInfolist" />
        </div>
    </div>

    {{-- With Prose --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">With Prose Typography</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tailwind Typography styling applied</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$proseInfolist" />
        </div>
    </div>

    {{-- Without Prose --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Without Prose Typography</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Basic text styling</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$noProseInfolist" />
        </div>
    </div>

    {{-- Max Height --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Scrollable Content</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Content with max height and scrolling</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$maxHeightInfolist" />
        </div>
    </div>

    {{-- Standalone Blade Component --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Standalone Blade Component</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Use directly in Blade without Infolist class</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-6">
                <x-infolists::html-entry
                    label="HTML Content"
                    value="<p>This is <strong>formatted</strong> HTML content with <em>styling</em>.</p>"
                />

                <x-infolists::html-entry
                    label="Markdown Content"
                    value="## Hello\n\nThis is **markdown** rendered as HTML."
                    :markdown="true"
                />
            </div>
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">&lt;x-infolists::html-entry
    label="HTML Content"
    value="&lt;p&gt;This is &lt;strong&gt;formatted&lt;/strong&gt; HTML.&lt;/p&gt;"
/&gt;

&lt;x-infolists::html-entry
    label="Markdown Content"
    value="## Hello\n\nThis is **markdown**."
    :markdown="true"
/&gt;</x-accelade::code-block>
        </div>
    </div>
</div>

@php
    use Accelade\Infolists\Infolist;
    use Accelade\Infolists\Components\TextEntry;

    $data = [
        'title' => 'Introduction to Laravel',
        'description' => 'Laravel is a **web application framework** with expressive, elegant syntax.',
        'price' => 4999,
        'published_at' => now()->subDays(5),
        'tags' => ['PHP', 'Laravel', 'Framework'],
        'status' => 'published',
        'priority' => 'high',
        'category' => 'Tutorial',
        'website' => 'https://laravel.com',
        'api_key' => 'sk_live_abc123xyz789',
        'email' => 'hello@example.com',
    ];

    // Basic text examples
    $basicInfolist = Infolist::make()
        ->record($data)
        ->columns(2)
        ->schema([
            TextEntry::make('title')
                ->label('Title')
                ->size('lg')
                ->weight('bold'),

            TextEntry::make('category')
                ->label('Category'),

            TextEntry::make('description')
                ->label('Description')
                ->markdown()
                ->columnSpanFull(),
        ]);

    // Badge examples
    $badgeInfolist = Infolist::make()
        ->record($data)
        ->columns(4)
        ->schema([
            TextEntry::make('status')
                ->label('Success Badge')
                ->badge()
                ->badgeColor('success')
                ->formatState(fn ($state) => ucfirst($state)),

            TextEntry::make('priority')
                ->label('Danger Badge')
                ->badge()
                ->badgeColor('danger')
                ->formatState(fn ($state) => ucfirst($state)),

            TextEntry::make('category')
                ->label('Info Badge')
                ->badge()
                ->badgeColor('info'),

            TextEntry::make('status')
                ->label('Warning Badge')
                ->badge()
                ->badgeColor('warning')
                ->formatState(fn () => 'Pending'),
        ]);

    // Array/List examples
    $listInfolist = Infolist::make()
        ->record($data)
        ->columns(2)
        ->schema([
            TextEntry::make('tags')
                ->label('Tags as Badges')
                ->badge()
                ->badgeColor('primary'),

            TextEntry::make('tags')
                ->label('Tags as Bulleted List')
                ->bulleted(),
        ]);

    // Formatting examples
    $formattingInfolist = Infolist::make()
        ->record($data)
        ->columns(3)
        ->schema([
            TextEntry::make('price')
                ->label('Price (USD)')
                ->money('USD'),

            TextEntry::make('published_at')
                ->label('Published Date')
                ->dateTime(),

            TextEntry::make('published_at')
                ->label('Time Ago')
                ->since()
                ->color('gray'),
        ]);

    // Icons with text examples
    $iconsInfolist = Infolist::make()
        ->record($data)
        ->columns(3)
        ->schema([
            TextEntry::make('email')
                ->label('Icon Before')
                ->icon('heroicon-o-envelope')
                ->iconPosition('before')
                ->iconColor('primary'),

            TextEntry::make('website')
                ->label('Icon After')
                ->icon('heroicon-o-globe-alt')
                ->iconPosition('after')
                ->iconColor('info'),

            TextEntry::make('status')
                ->label('Success Icon')
                ->icon('heroicon-o-check-circle')
                ->iconPosition('before')
                ->iconColor('success'),

            TextEntry::make('priority')
                ->label('Warning Icon')
                ->icon('heroicon-o-exclamation-triangle')
                ->iconPosition('before')
                ->iconColor('warning'),

            TextEntry::make('api_key')
                ->label('Danger Icon')
                ->icon('heroicon-o-lock-closed')
                ->iconPosition('before')
                ->iconColor('danger'),

            TextEntry::make('category')
                ->label('Badge with Icon')
                ->badge()
                ->badgeColor('primary')
                ->icon('heroicon-o-tag')
                ->iconPosition('before'),
        ]);

    // Interactive examples
    $interactiveInfolist = Infolist::make()
        ->record($data)
        ->columns(2)
        ->schema([
            TextEntry::make('website')
                ->label('External Link')
                ->url(fn ($record) => $record['website'])
                ->openUrlInNewTab()
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->iconPosition('after')
                ->color('primary'),

            TextEntry::make('api_key')
                ->label('API Key (Copyable)')
                ->copyable()
                ->copyMessage('API Key copied!')
                ->icon('heroicon-o-key')
                ->iconPosition('before'),

            TextEntry::make('email')
                ->label('Email (Click to Copy)')
                ->copyable()
                ->copyMessage('Email copied!')
                ->icon('heroicon-o-envelope')
                ->iconPosition('before')
                ->color('info'),
        ]);
@endphp

<div class="space-y-8">
    {{-- Basic Text --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Basic Text Display</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Simple text with size and weight options</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$basicInfolist" />
        </div>
    </div>

    {{-- Badge Variations --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Badge Styles</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Text displayed as colored badges with ring styling</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$badgeInfolist" />
        </div>
    </div>

    {{-- List/Array Values --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Array Values</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Display arrays as badges or bulleted lists</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$listInfolist" />
        </div>
    </div>

    {{-- Formatting Options --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Formatting</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Money, date/time, and relative time formatting</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$formattingInfolist" />
        </div>
    </div>

    {{-- Icons with Text --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Icons with Text</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Display icons before or after text with color options</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$iconsInfolist" />
        </div>
    </div>

    {{-- Interactive Features --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Interactive Features</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Links, copy-to-clipboard, and icons</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$interactiveInfolist" />
        </div>
    </div>

    {{-- Standalone Blade Component --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Standalone Blade Component</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Use directly in Blade without Infolist class</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-infolists::text-entry
                    label="Name"
                    value="John Doe"
                />

                <x-infolists::text-entry
                    label="Email"
                    value="john@example.com"
                    icon="heroicon-o-envelope"
                    iconPosition="before"
                />

                <x-infolists::text-entry
                    label="Price"
                    value="$99.00"
                    size="lg"
                    weight="bold"
                    color="success"
                />
            </div>
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">&lt;x-infolists::text-entry
    label="Name"
    value="John Doe"
/&gt;

&lt;x-infolists::text-entry
    label="Email"
    value="john@example.com"
    icon="heroicon-o-envelope"
    iconPosition="before"
/&gt;

&lt;x-infolists::text-entry
    label="Price"
    value="$99.00"
    size="lg"
    weight="bold"
    color="success"
/&gt;</x-accelade::code-block>
        </div>
    </div>
</div>

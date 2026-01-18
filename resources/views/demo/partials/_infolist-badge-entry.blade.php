@php
    use Accelade\Infolist\Infolist;
    use Accelade\Infolist\Components\BadgeEntry;

    $data = [
        'status' => 'published',
        'priority' => 'high',
        'type' => 'article',
        'is_active' => true,
        'is_featured' => false,
        'role' => 'admin',
        'tier' => 'premium',
        'category' => 'technology',
    ];

    // Color mapping examples
    $colorMappingInfolist = Infolist::make()
        ->record($data)
        ->columns(4)
        ->schema([
            BadgeEntry::make('status')
                ->label('Status')
                ->colors([
                    'published' => 'success',
                    'draft' => 'gray',
                    'pending' => 'warning',
                    'archived' => 'danger',
                ]),

            BadgeEntry::make('priority')
                ->label('Priority')
                ->colors([
                    'high' => 'danger',
                    'medium' => 'warning',
                    'low' => 'info',
                ]),

            BadgeEntry::make('role')
                ->label('Role')
                ->colors([
                    'admin' => 'primary',
                    'moderator' => 'info',
                    'user' => 'gray',
                ]),

            BadgeEntry::make('tier')
                ->label('Tier')
                ->colors([
                    'premium' => 'warning',
                    'pro' => 'success',
                    'free' => 'gray',
                ]),
        ]);

    // Boolean badges
    $booleanInfolist = Infolist::make()
        ->record($data)
        ->columns(2)
        ->schema([
            BadgeEntry::make('is_active')
                ->label('Active Status')
                ->bool('Active', 'Inactive'),

            BadgeEntry::make('is_featured')
                ->label('Featured Status')
                ->bool('Featured', 'Not Featured'),
        ]);

    // With icons
    $withIconsInfolist = Infolist::make()
        ->record($data)
        ->columns(3)
        ->schema([
            BadgeEntry::make('status')
                ->label('With Icon Before')
                ->icon('heroicon-o-check-circle')
                ->iconPosition('before')
                ->colors([
                    'published' => 'success',
                ]),

            BadgeEntry::make('priority')
                ->label('With Icon After')
                ->icon('heroicon-o-exclamation-triangle')
                ->iconPosition('after')
                ->colors([
                    'high' => 'danger',
                ]),

            BadgeEntry::make('category')
                ->label('Info Badge')
                ->icon('heroicon-o-tag')
                ->iconPosition('before')
                ->color('info'),
        ]);

    // All color variants
    $colorsInfolist = Infolist::make()
        ->record([
            'primary' => 'Primary',
            'secondary' => 'Secondary',
            'success' => 'Success',
            'danger' => 'Danger',
            'warning' => 'Warning',
            'info' => 'Info',
        ])
        ->columns(6)
        ->schema([
            BadgeEntry::make('primary')
                ->hiddenLabel()
                ->color('primary'),

            BadgeEntry::make('secondary')
                ->hiddenLabel()
                ->color('gray'),

            BadgeEntry::make('success')
                ->hiddenLabel()
                ->color('success'),

            BadgeEntry::make('danger')
                ->hiddenLabel()
                ->color('danger'),

            BadgeEntry::make('warning')
                ->hiddenLabel()
                ->color('warning'),

            BadgeEntry::make('info')
                ->hiddenLabel()
                ->color('info'),
        ]);
@endphp

<div class="space-y-8">
    {{-- Color Mapping --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Color Mapping</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Automatically color badges based on state values</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$colorMappingInfolist" />
        </div>
    </div>

    {{-- Boolean Badges --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Boolean Badges</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Display true/false values with custom labels and colors</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$booleanInfolist" />
        </div>
    </div>

    {{-- With Icons --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Badges with Icons</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Add icons before or after badge text</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$withIconsInfolist" />
        </div>
    </div>

    {{-- All Color Variants --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">All Color Variants</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Filament-style badge colors with ring styling</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$colorsInfolist" />
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
                <x-infolists::badge-entry
                    label="Status"
                    value="Published"
                    color="success"
                />

                <x-infolists::badge-entry
                    label="Priority"
                    value="High"
                    color="danger"
                    icon="heroicon-o-exclamation-triangle"
                />

                <x-infolists::badge-entry
                    label="Category"
                    value="Technology"
                    color="info"
                    icon="heroicon-o-tag"
                    iconPosition="before"
                />
            </div>
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">&lt;x-infolists::badge-entry
    label="Status"
    value="Published"
    color="success"
/&gt;

&lt;x-infolists::badge-entry
    label="Priority"
    value="High"
    color="danger"
    icon="heroicon-o-exclamation-triangle"
/&gt;

&lt;x-infolists::badge-entry
    label="Category"
    value="Technology"
    color="info"
    icon="heroicon-o-tag"
    iconPosition="before"
/&gt;</x-accelade::code-block>
        </div>
    </div>
</div>

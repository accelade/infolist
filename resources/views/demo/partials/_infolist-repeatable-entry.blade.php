@php
    use Accelade\Infolist\Infolist;
    use Accelade\Infolist\Components\RepeatableEntry;
    use Accelade\Infolist\Components\TextEntry;
    use Accelade\Infolist\Components\ImageEntry;
    use Accelade\Infolist\Components\IconEntry;

    $data = [
        'comments' => [
            [
                'author' => 'Alice Johnson',
                'avatar' => 'https://i.pravatar.cc/150?u=alice',
                'content' => 'This is amazing! Great work on the new feature.',
                'created_at' => now()->subHours(2),
                'is_verified' => true,
            ],
            [
                'author' => 'Bob Smith',
                'avatar' => 'https://i.pravatar.cc/150?u=bob',
                'content' => 'I have a question about the implementation details.',
                'created_at' => now()->subDays(1),
                'is_verified' => false,
            ],
        ],
        'team' => [
            [
                'name' => 'Sarah Chen',
                'avatar' => 'https://i.pravatar.cc/150?u=sarah',
                'role' => 'Backend Engineer',
            ],
            [
                'name' => 'Mike Ross',
                'avatar' => 'https://i.pravatar.cc/150?u=mike',
                'role' => 'UI/UX Designer',
            ],
            [
                'name' => 'Emma Davis',
                'avatar' => 'https://i.pravatar.cc/150?u=emma',
                'role' => 'Project Manager',
            ],
            [
                'name' => 'James Wilson',
                'avatar' => 'https://i.pravatar.cc/150?u=james',
                'role' => 'Frontend Engineer',
            ],
        ],
    ];

    // Comments with contained layout
    $commentsInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            RepeatableEntry::make('comments')
                ->contained()
                ->schema([
                    ImageEntry::make('avatar')
                        ->circular()
                        ->size('md'),

                    TextEntry::make('author')
                        ->weight('semibold'),

                    IconEntry::make('is_verified')
                        ->boolean()
                        ->trueIcon('heroicon-o-check-badge')
                        ->falseIcon('heroicon-o-x-circle')
                        ->trueColor('success')
                        ->falseColor('gray')
                        ->size('sm'),

                    TextEntry::make('content')
                        ->color('gray')
                        ->columnSpanFull(),

                    TextEntry::make('created_at')
                        ->since()
                        ->size('sm')
                        ->color('gray'),
                ]),
        ]);

    // Team grid
    $teamInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            RepeatableEntry::make('team')
                ->grid()
                ->gridColumns(4)
                ->schema([
                    ImageEntry::make('avatar')
                        ->circular()
                        ->size('xl'),

                    TextEntry::make('name')
                        ->weight('bold'),

                    TextEntry::make('role')
                        ->size('sm')
                        ->color('gray'),
                ]),
        ]);

    // Simple list
    $simpleInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            RepeatableEntry::make('team')
                ->simple()
                ->schema([
                    ImageEntry::make('avatar')
                        ->circular()
                        ->size('sm'),

                    TextEntry::make('name')
                        ->weight('semibold'),

                    TextEntry::make('role')
                        ->badge()
                        ->badgeColor('primary'),
                ]),
        ]);
@endphp

<div class="space-y-8">
    {{-- Comments Section --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Comments (Contained Layout)</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Each item wrapped in a contained card</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$commentsInfolist" />
        </div>
    </div>

    {{-- Team Grid --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Team Members (Grid Layout)</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Display items in a responsive grid</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$teamInfolist" />
        </div>
    </div>

    {{-- Simple List --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Simple List</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Compact inline layout with minimal spacing</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$simpleInfolist" />
        </div>
    </div>

    {{-- Standalone Blade Component --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Standalone Blade Component</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Use directly in Blade without Infolist class (uses slot for content)</p>
        </div>
        <div class="p-6">
            @php
            $standaloneItems = [
                ['name' => 'Item 1', 'value' => 'Value 1'],
                ['name' => 'Item 2', 'value' => 'Value 2'],
                ['name' => 'Item 3', 'value' => 'Value 3'],
            ];
            @endphp

            <x-infolists::repeatable-entry
                label="Standalone Repeatable"
                :items="$standaloneItems"
                :contained="true"
            >
                <div class="flex items-center justify-between w-full">
                    <span class="font-medium text-gray-900 dark:text-white">Item Name</span>
                    <span class="text-gray-500 dark:text-gray-400">Item Value</span>
                </div>
            </x-infolists::repeatable-entry>
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">@verbatim@php
$items = [
    ['name' => 'Item 1', 'value' => 'Value 1'],
    ['name' => 'Item 2', 'value' => 'Value 2'],
];
@endphp

<x-infolists::repeatable-entry
    label="My Items"
    :items="$items"
    :contained="true"
>
    <div class="flex justify-between">
        <span>Item content</span>
    </div>
</x-infolists::repeatable-entry>@endverbatim</x-accelade::code-block>
        </div>
    </div>
</div>

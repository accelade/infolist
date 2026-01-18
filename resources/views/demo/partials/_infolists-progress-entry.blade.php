@php
    use Accelade\Infolists\Infolist;
    use Accelade\Infolists\Components\ProgressEntry;

    $data = [
        'completion' => 75,
        'low' => 15,
        'medium' => 45,
        'high' => 85,
        'tasks' => 7,
        'total_tasks' => 10,
        'storage' => 3.5,
        'storage_limit' => 5,
    ];

    // Basic Progress
    $basicInfolist = Infolist::make()
        ->record($data)
        ->schema([
            ProgressEntry::make('completion')
                ->label('Completion'),
        ]);

    // Auto-Coloring
    $autoColorInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            ProgressEntry::make('low')
                ->label('Low (15%)'),
            ProgressEntry::make('medium')
                ->label('Medium (45%)'),
            ProgressEntry::make('completion')
                ->label('High (75%)'),
            ProgressEntry::make('high')
                ->label('Very High (85%)'),
        ]);

    // Custom Colors
    $colorsInfolist = Infolist::make()
        ->record($data)
        ->columns(2)
        ->schema([
            ProgressEntry::make('completion')
                ->label('Primary')
                ->color('primary'),
            ProgressEntry::make('completion')
                ->label('Success')
                ->color('success'),
            ProgressEntry::make('completion')
                ->label('Warning')
                ->color('warning'),
            ProgressEntry::make('completion')
                ->label('Danger')
                ->color('danger'),
        ]);

    // Different Heights
    $heightsInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            ProgressEntry::make('completion')
                ->label('Extra Small')
                ->height('xs')
                ->color('primary'),
            ProgressEntry::make('completion')
                ->label('Small')
                ->height('sm')
                ->color('primary'),
            ProgressEntry::make('completion')
                ->label('Medium (Default)')
                ->height('md')
                ->color('primary'),
            ProgressEntry::make('completion')
                ->label('Large')
                ->height('lg')
                ->color('primary'),
            ProgressEntry::make('completion')
                ->label('Extra Large')
                ->height('xl')
                ->color('primary'),
        ]);

    // Striped and Animated
    $stripedInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            ProgressEntry::make('completion')
                ->label('Striped')
                ->striped()
                ->color('info'),
            ProgressEntry::make('completion')
                ->label('Animated')
                ->animated()
                ->color('success'),
        ]);

    // Custom Labels
    $labelsInfolist = Infolist::make()
        ->record(array_merge($data, ['tasks' => 7, 'total_tasks' => 10]))
        ->columns(1)
        ->schema([
            ProgressEntry::make('tasks')
                ->label('Tasks Completed')
                ->max(10)
                ->labelFormat('{value} of {max}')
                ->color('primary'),
            ProgressEntry::make('storage')
                ->label('Storage Used')
                ->max(5)
                ->labelFormat('{value} GB / {max} GB')
                ->color('warning'),
        ]);

    // Hidden Label
    $noLabelInfolist = Infolist::make()
        ->record($data)
        ->schema([
            ProgressEntry::make('completion')
                ->label('Progress (Hidden Label)')
                ->hideLabel()
                ->color('primary'),
        ]);
@endphp

<div class="space-y-8">
    {{-- Basic Progress --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Basic Progress Bar</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Simple progress bar with auto-coloring</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$basicInfolist" />
        </div>
    </div>

    {{-- Auto-Coloring --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Auto-Coloring</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Colors change based on percentage</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$autoColorInfolist" />
        </div>
    </div>

    {{-- Custom Colors --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Custom Colors</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Fixed color for progress bars</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$colorsInfolist" />
        </div>
    </div>

    {{-- Different Heights --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Different Heights</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Progress bars in various sizes</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$heightsInfolist" />
        </div>
    </div>

    {{-- Striped and Animated --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Striped & Animated</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Progress bars with stripes and animation</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$stripedInfolist" />
        </div>
    </div>

    {{-- Custom Labels --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Custom Labels</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Custom label format with placeholders</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$labelsInfolist" />
        </div>
    </div>

    {{-- Hidden Label --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Hidden Label</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Progress bar without percentage display</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$noLabelInfolist" />
        </div>
    </div>

    {{-- Standalone Blade Component --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Standalone Blade Component</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Use directly in Blade without Infolist class</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-6 max-w-2xl">
                <x-infolists::progress-entry
                    label="Download Progress"
                    :value="75"
                    color="primary"
                />

                <x-infolists::progress-entry
                    label="Upload Progress"
                    :value="45"
                    color="success"
                    :striped="true"
                />

                <x-infolists::progress-entry
                    label="Processing..."
                    :value="60"
                    color="info"
                    :animated="true"
                />
            </div>
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">&lt;x-infolists::progress-entry
    label="Download Progress"
    :value="75"
    color="primary"
/&gt;

&lt;x-infolists::progress-entry
    label="Upload Progress"
    :value="45"
    color="success"
    :striped="true"
/&gt;

&lt;x-infolists::progress-entry
    label="Processing..."
    :value="60"
    color="info"
    :animated="true"
/&gt;</x-accelade::code-block>
        </div>
    </div>
</div>

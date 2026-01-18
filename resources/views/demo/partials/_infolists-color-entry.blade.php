@php
    use Accelade\Infolists\Infolist;
    use Accelade\Infolists\Components\ColorEntry;

    $data = [
        'primary' => '#3B82F6',
        'secondary' => '#6B7280',
        'success' => '#10B981',
        'warning' => '#F59E0B',
        'danger' => '#EF4444',
        'info' => '#06B6D4',
    ];

    $infolist = Infolist::make()
        ->record($data)
        ->columns(3)
        ->schema([
            ColorEntry::make('primary')
                ->label('Primary')
                ->copyable(),

            ColorEntry::make('secondary')
                ->label('Secondary')
                ->copyable(),

            ColorEntry::make('success')
                ->label('Success')
                ->copyable(),

            ColorEntry::make('warning')
                ->label('Warning')
                ->copyable(),

            ColorEntry::make('danger')
                ->label('Danger')
                ->copyable(),

            ColorEntry::make('info')
                ->label('Info')
                ->copyable(),
        ]);
@endphp

<div class="space-y-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Color Entry Examples</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Display and copy color values with preview swatches</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$infolist" />
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
                <x-infolists::color-entry
                    label="Brand Color"
                    value="#3B82F6"
                    :copyable="true"
                />

                <x-infolists::color-entry
                    label="Accent Color"
                    value="#10B981"
                    :copyable="true"
                />

                <x-infolists::color-entry
                    label="Warning Color"
                    value="#F59E0B"
                />
            </div>
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">&lt;x-infolists::color-entry
    label="Brand Color"
    value="#3B82F6"
    :copyable="true"
/&gt;

&lt;x-infolists::color-entry
    label="Accent Color"
    value="#10B981"
    :copyable="true"
/&gt;

&lt;x-infolists::color-entry
    label="Warning Color"
    value="#F59E0B"
/&gt;</x-accelade::code-block>
        </div>
    </div>
</div>

@php
    use Accelade\Infolists\Infolist;
    use Accelade\Infolists\Components\KeyValueEntry;

    $data = [
        'metadata' => [
            'version' => '1.0.0',
            'author' => 'Accelade Team',
            'license' => 'MIT',
            'php' => '>= 8.2',
            'laravel' => '^11.0 || ^12.0',
        ],
        'settings' => [
            'debug' => true,
            'cache' => 'redis',
            'queue' => 'database',
            'timezone' => 'UTC',
        ],
    ];

    $infolist = Infolist::make()
        ->record($data)
        ->columns(2)
        ->schema([
            KeyValueEntry::make('metadata')
                ->label('Package Metadata')
                ->keyLabel('Property')
                ->valueLabel('Value'),

            KeyValueEntry::make('settings')
                ->label('Application Settings')
                ->keyLabel('Setting')
                ->valueLabel('Current Value'),
        ]);
@endphp

<div class="space-y-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Key Value Entry Examples</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Display key-value pairs in a table format</p>
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
            <x-infolists::key-value-entry
                label="Server Info"
                :value="['PHP Version' => '8.3', 'Laravel' => '12.0', 'OS' => 'Ubuntu 22.04']"
                keyLabel="Property"
                valueLabel="Value"
            />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">&lt;x-infolists::key-value-entry
    label="Server Info"
    :value="['PHP Version' => '8.3', 'Laravel' => '12.0', 'OS' => 'Ubuntu 22.04']"
    keyLabel="Property"
    valueLabel="Value"
/&gt;</x-accelade::code-block>
        </div>
    </div>
</div>

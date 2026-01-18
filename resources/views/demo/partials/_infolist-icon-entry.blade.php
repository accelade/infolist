@php
    use Accelade\Infolist\Infolist;
    use Accelade\Infolist\Components\IconEntry;

    $data = [
        'is_verified' => true,
        'is_subscribed' => false,
        'role' => 'admin',
        'status' => 'active',
    ];

    $infolist = Infolist::make()
        ->record($data)
        ->columns(2)
        ->schema([
            IconEntry::make('is_verified')
                ->label('Email Verified')
                ->boolean()
                ->trueIcon('heroicon-o-check-badge')
                ->falseIcon('heroicon-o-x-circle')
                ->trueColor('success')
                ->falseColor('danger'),

            IconEntry::make('is_subscribed')
                ->label('Newsletter')
                ->boolean(),

            IconEntry::make('role')
                ->icon(fn ($state) => match ($state) {
                    'admin' => 'heroicon-o-shield-check',
                    'editor' => 'heroicon-o-pencil',
                    default => 'heroicon-o-user',
                })
                ->color(fn ($state) => match ($state) {
                    'admin' => 'danger',
                    'editor' => 'warning',
                    default => 'gray',
                })
                ->size('xl')
                ->tooltip('User Role'),

            IconEntry::make('status')
                ->icon('heroicon-o-signal')
                ->color('success')
                ->size('lg'),
        ]);
@endphp

<div class="space-y-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Icon Entry Examples</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Boolean icons, dynamic colors, and sizes</p>
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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <x-infolists::icon-entry
                    label="Verified"
                    :value="true"
                    :boolean="true"
                />

                <x-infolists::icon-entry
                    label="Not Verified"
                    :value="false"
                    :boolean="true"
                />

                <x-infolists::icon-entry
                    label="Admin Role"
                    icon="heroicon-o-shield-check"
                    color="danger"
                    size="lg"
                />

                <x-infolists::icon-entry
                    label="Online Status"
                    icon="heroicon-o-signal"
                    color="success"
                    size="xl"
                    tooltip="User is online"
                />
            </div>
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">&lt;x-infolists::icon-entry
    label="Verified"
    :value="true"
    :boolean="true"
/&gt;

&lt;x-infolists::icon-entry
    label="Admin Role"
    icon="heroicon-o-shield-check"
    color="danger"
    size="lg"
/&gt;

&lt;x-infolists::icon-entry
    label="Online Status"
    icon="heroicon-o-signal"
    color="success"
    size="xl"
    tooltip="User is online"
/&gt;</x-accelade::code-block>
        </div>
    </div>
</div>

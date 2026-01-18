@php
    use Accelade\Infolists\Infolist;
    use Accelade\Infolists\Components\SeparatorEntry;
    use Accelade\Infolists\Components\TextEntry;

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+1 555-0123',
    ];

    // Basic Separator
    $basicInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            TextEntry::make('name')
                ->label('Name'),
            SeparatorEntry::make('divider1'),
            TextEntry::make('email')
                ->label('Email'),
        ]);

    // Line Styles
    $stylesInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            TextEntry::make('name')
                ->label('Solid Line (Default)'),
            SeparatorEntry::make('solid'),
            TextEntry::make('name')
                ->label('Dashed Line'),
            SeparatorEntry::make('dashed')->dashed(),
            TextEntry::make('name')
                ->label('Dotted Line'),
            SeparatorEntry::make('dotted')->dotted(),
        ]);

    // Thickness
    $thicknessInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            SeparatorEntry::make('thin')
                ->thin(),
            SeparatorEntry::make('medium')
                ->medium(),
            SeparatorEntry::make('thick')
                ->thick(),
        ]);

    // Colors
    $colorsInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            SeparatorEntry::make('primary')
                ->separatorColor('primary')
                ->medium(),
            SeparatorEntry::make('success')
                ->separatorColor('success')
                ->medium(),
            SeparatorEntry::make('danger')
                ->separatorColor('danger')
                ->medium(),
            SeparatorEntry::make('warning')
                ->separatorColor('warning')
                ->medium(),
        ]);

    // Text Dividers
    $textInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            SeparatorEntry::make('or')
                ->text('OR'),
            SeparatorEntry::make('section')
                ->text('Section Title')
                ->textLeft(),
            SeparatorEntry::make('end')
                ->text('End')
                ->textRight(),
        ]);

    // Combined Example
    $combinedInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            TextEntry::make('name')
                ->label('Name'),
            TextEntry::make('email')
                ->label('Email'),
            SeparatorEntry::make('divider')
                ->text('Contact Information')
                ->dashed()
                ->separatorColor('primary'),
            TextEntry::make('phone')
                ->label('Phone'),
        ]);
@endphp

<div class="space-y-8">
    {{-- Basic Separator --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Basic Separator</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Simple horizontal divider between entries</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$basicInfolist" />
        </div>
    </div>

    {{-- Line Styles --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Line Styles</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Solid, dashed, and dotted styles</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$stylesInfolist" />
        </div>
    </div>

    {{-- Thickness --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Thickness</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Thin, medium, and thick separators</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$thicknessInfolist" />
        </div>
    </div>

    {{-- Colors --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Colors</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Separators with different colors</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$colorsInfolist" />
        </div>
    </div>

    {{-- Text Dividers --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Text Dividers</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Separators with text labels</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$textInfolist" />
        </div>
    </div>

    {{-- Combined Example --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Combined Features</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Text divider with dashed style and custom color</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$combinedInfolist" />
        </div>
    </div>

    {{-- Standalone Blade Component --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Standalone Blade Component</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Use directly in Blade without Infolist class</p>
        </div>
        <div class="p-6 space-y-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Simple separator:</p>
            <x-infolists::separator-entry />

            <p class="text-sm text-gray-600 dark:text-gray-400">Dashed with text:</p>
            <x-infolists::separator-entry
                text="OR"
                style="dashed"
            />

            <p class="text-sm text-gray-600 dark:text-gray-400">Primary color, thick:</p>
            <x-infolists::separator-entry
                color="primary"
                thickness="thick"
            />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">&lt;x-infolists::separator-entry /&gt;

&lt;x-infolists::separator-entry
    text="OR"
    style="dashed"
/&gt;

&lt;x-infolists::separator-entry
    color="primary"
    thickness="thick"
/&gt;</x-accelade::code-block>
        </div>
    </div>
</div>

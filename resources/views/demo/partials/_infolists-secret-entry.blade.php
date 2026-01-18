@php
    use Accelade\Infolists\Infolist;
    use Accelade\Infolists\Components\SecretEntry;

    $data = [
        'api_key' => 'sk_live_abc123xyz789def456',
        'password' => 'supersecretpassword123',
        'card_number' => '4242424242424242',
        'token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9',
        'webhook_secret' => 'whsec_abcdef123456',
    ];

    // Basic Secret
    $basicInfolist = Infolist::make()
        ->record($data)
        ->schema([
            SecretEntry::make('api_key')
                ->label('API Key'),
        ]);

    // Show Last Characters
    $lastCharsInfolist = Infolist::make()
        ->record($data)
        ->schema([
            SecretEntry::make('api_key')
                ->label('API Key (Last 4 Visible)')
                ->showLast(4),
        ]);

    // Show First Characters
    $firstCharsInfolist = Infolist::make()
        ->record($data)
        ->schema([
            SecretEntry::make('card_number')
                ->label('Card Number (First 4 Visible)')
                ->showFirst(4),
        ]);

    // Custom Mask
    $customMaskInfolist = Infolist::make()
        ->record($data)
        ->schema([
            SecretEntry::make('password')
                ->label('Password (Custom Mask)')
                ->mask('••••••••••'),
        ]);

    // Reveal on Hover
    $hoverInfolist = Infolist::make()
        ->record($data)
        ->schema([
            SecretEntry::make('token')
                ->label('Token (Hover to Reveal)')
                ->revealOnHover()
                ->revealOnClick(false),
        ]);

    // Auto-Hide
    $autoHideInfolist = Infolist::make()
        ->record($data)
        ->schema([
            SecretEntry::make('webhook_secret')
                ->label('Webhook Secret (Auto-hides after 3s)')
                ->showLast(6)
                ->autoHideAfter(3),
        ]);

    // No Reveal
    $noRevealInfolist = Infolist::make()
        ->record($data)
        ->schema([
            SecretEntry::make('password')
                ->label('Password (No Reveal)')
                ->revealOnClick(false)
                ->revealOnHover(false),
        ]);

    // Combined Example
    $combinedInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            SecretEntry::make('api_key')
                ->label('Live API Key')
                ->showLast(4)
                ->autoHideAfter(5),
            SecretEntry::make('card_number')
                ->label('Card Number')
                ->showFirst(4)
                ->mask('•••• •••• •••• '),
            SecretEntry::make('webhook_secret')
                ->label('Webhook Secret')
                ->revealOnHover(),
        ]);
@endphp

<div class="space-y-8">
    {{-- Basic Secret --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Basic Secret</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Click the eye icon to reveal</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$basicInfolist" />
        </div>
    </div>

    {{-- Show Last Characters --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Show Last Characters</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Shows last 4 characters of the value</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$lastCharsInfolist" />
        </div>
    </div>

    {{-- Show First Characters --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Show First Characters</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Shows first 4 characters of the value</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$firstCharsInfolist" />
        </div>
    </div>

    {{-- Custom Mask --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Custom Mask</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Uses bullet points as mask</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$customMaskInfolist" />
        </div>
    </div>

    {{-- Reveal on Hover --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Reveal on Hover</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Hover over the value to reveal</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$hoverInfolist" />
        </div>
    </div>

    {{-- Auto-Hide --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Auto-Hide</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Automatically hides after 3 seconds</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$autoHideInfolist" />
        </div>
    </div>

    {{-- No Reveal --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">No Reveal Option</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Cannot be revealed (always masked)</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$noRevealInfolist" />
        </div>
    </div>

    {{-- Combined Example --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Combined Features</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Multiple secrets with different configurations</p>
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
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-infolists::secret-entry
                    label="API Key"
                    value="sk_live_abc123xyz789"
                />

                <x-infolists::secret-entry
                    label="Password"
                    value="supersecret123"
                    :revealOnHover="true"
                    :revealOnClick="false"
                />
            </div>
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">&lt;x-infolists::secret-entry
    label="API Key"
    value="sk_live_abc123xyz789"
/&gt;

&lt;x-infolists::secret-entry
    label="Password"
    value="supersecret123"
    :revealOnHover="true"
    :revealOnClick="false"
/&gt;</x-accelade::code-block>
        </div>
    </div>
</div>

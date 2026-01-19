@php
    use Accelade\Infolists\Infolist;
    use Accelade\Infolists\Components\CodeEntry;

    $data = [
        'php_code' => "<?php\n\nnamespace App\\Models;\n\nuse Illuminate\\Database\\Eloquent\\Model;\n\nclass User extends Model\n{\n    protected \$fillable = [\n        'name',\n        'email',\n    ];\n}",
        'json_data' => [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'roles' => ['admin', 'editor'],
            'settings' => [
                'theme' => 'dark',
                'notifications' => true,
            ],
        ],
        'sql_query' => "SELECT users.*, posts.title\nFROM users\nLEFT JOIN posts ON posts.user_id = users.id\nWHERE users.active = 1\nORDER BY users.created_at DESC\nLIMIT 10;",
        'bash_command' => "#!/bin/bash\n\n# Deploy script\necho \"Starting deployment...\"\n\nphp artisan down\ngit pull origin main\ncomposer install --no-dev\nphp artisan migrate --force\nphp artisan optimize\nphp artisan up\n\necho \"Deployment complete!\"",
        'html_snippet' => "<div class=\"card\">\n    <h2>Welcome</h2>\n    <p>Hello, World!</p>\n    <button>Click Me</button>\n</div>",
    ];

    // PHP Code
    $phpInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            CodeEntry::make('php_code')
                ->label('PHP Code')
                ->php()
                ->lineNumbers(),
        ]);

    // JSON Data
    $jsonInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            CodeEntry::make('json_data')
                ->label('JSON Data')
                ->json()
                ->lineNumbers(),
        ]);

    // SQL Query
    $sqlInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            CodeEntry::make('sql_query')
                ->label('SQL Query')
                ->sql()
                ->lineNumbers(false),
        ]);

    // Bash Script with max height
    $bashInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            CodeEntry::make('bash_command')
                ->label('Bash Script (Max Height 150px)')
                ->bash()
                ->maxHeight(150)
                ->lineNumbers(),
        ]);

    // HTML without copy
    $htmlInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            CodeEntry::make('html_snippet')
                ->label('HTML (Non-Copyable)')
                ->html()
                ->copyable(false)
                ->lineNumbers(),
        ]);
@endphp

<div class="space-y-8">
    {{-- PHP Code --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">PHP Code</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Display PHP code with line numbers and copy button</p>
        </div>
        <div class="p-6">
            <x-accelade::infolist :infolist="$phpInfolist" />
        </div>
    </div>

    {{-- JSON Data --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">JSON Data</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Automatically formats arrays/objects as pretty JSON</p>
        </div>
        <div class="p-6">
            <x-accelade::infolist :infolist="$jsonInfolist" />
        </div>
    </div>

    {{-- SQL Query --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">SQL Query</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">SQL syntax without line numbers</p>
        </div>
        <div class="p-6">
            <x-accelade::infolist :infolist="$sqlInfolist" />
        </div>
    </div>

    {{-- Bash Script --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Bash Script with Max Height</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Scrollable code block with limited height</p>
        </div>
        <div class="p-6">
            <x-accelade::infolist :infolist="$bashInfolist" />
        </div>
    </div>

    {{-- HTML Snippet --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">HTML (Non-Copyable)</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Code block with copy button disabled</p>
        </div>
        <div class="p-6">
            <x-accelade::infolist :infolist="$htmlInfolist" />
        </div>
    </div>

    {{-- Standalone Blade Component --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Standalone Blade Component</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Use directly in Blade without Infolist class</p>
        </div>
        <div class="p-6">
            <x-accelade::code-entry
                label="Configuration"
                value="return ['debug' => true, 'cache' => 'redis'];"
                language="php"
            />
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">&lt;x-accelade::code-entry
    label="Configuration"
    value="return ['debug' => true, 'cache' => 'redis'];"
    language="php"
/&gt;</x-accelade::code-block>
        </div>
    </div>
</div>

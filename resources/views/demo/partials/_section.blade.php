@props([
    'title',
    'description' => null,
    'infolist',
])

<section class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            {{ $title }}
        </h2>
        @if ($description)
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ $description }}
            </p>
        @endif
    </div>

    <div class="p-6">
        <x-infolists::infolist :infolist="$infolist" />
    </div>
</section>

@php
    use Accelade\Infolists\Infolist;
    use Accelade\Infolists\Components\RatingEntry;

    $data = [
        'rating' => 4,
        'half_rating' => 3.5,
        'low_rating' => 2,
        'popularity' => 4,
        'quality' => 5,
    ];

    // Basic Stars
    $basicInfolist = Infolist::make()
        ->record($data)
        ->schema([
            RatingEntry::make('rating')
                ->label('Rating')
                ->stars(),
        ]);

    // Half Stars
    $halfInfolist = Infolist::make()
        ->record($data)
        ->schema([
            RatingEntry::make('half_rating')
                ->label('Rating with Half Stars')
                ->stars()
                ->allowHalf(),
        ]);

    // Hearts
    $heartsInfolist = Infolist::make()
        ->record($data)
        ->schema([
            RatingEntry::make('popularity')
                ->label('Popularity')
                ->hearts(),
        ]);

    // Custom Max
    $customMaxInfolist = Infolist::make()
        ->record($data)
        ->schema([
            RatingEntry::make('quality')
                ->label('Quality (10 Stars)')
                ->stars(10),
        ]);

    // Different Sizes
    $sizesInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            RatingEntry::make('rating')
                ->label('Extra Small')
                ->stars()
                ->ratingSize('xs'),
            RatingEntry::make('rating')
                ->label('Small')
                ->stars()
                ->ratingSize('sm'),
            RatingEntry::make('rating')
                ->label('Medium (Default)')
                ->stars()
                ->ratingSize('md'),
            RatingEntry::make('rating')
                ->label('Large')
                ->stars()
                ->ratingSize('lg'),
            RatingEntry::make('rating')
                ->label('Extra Large')
                ->stars()
                ->ratingSize('xl'),
        ]);

    // Custom Colors
    $colorsInfolist = Infolist::make()
        ->record($data)
        ->columns(2)
        ->schema([
            RatingEntry::make('rating')
                ->label('Success Color')
                ->stars()
                ->filledColor('success'),
            RatingEntry::make('rating')
                ->label('Danger Color')
                ->stars()
                ->filledColor('danger'),
            RatingEntry::make('rating')
                ->label('Primary Color')
                ->stars()
                ->filledColor('primary'),
            RatingEntry::make('rating')
                ->label('Info Color')
                ->stars()
                ->filledColor('info'),
        ]);
@endphp

<div class="space-y-8">
    {{-- Basic Stars --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Basic Star Rating</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Default 5-star rating display</p>
        </div>
        <div class="p-6">
            <x-accelade::infolist :infolist="$basicInfolist" />
        </div>
    </div>

    {{-- Half Stars --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Half Stars</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Rating with half-star support for decimal values</p>
        </div>
        <div class="p-6">
            <x-accelade::infolist :infolist="$halfInfolist" />
        </div>
    </div>

    {{-- Hearts --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Heart Rating</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Rating displayed with heart icons</p>
        </div>
        <div class="p-6">
            <x-accelade::infolist :infolist="$heartsInfolist" />
        </div>
    </div>

    {{-- Custom Max --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Custom Maximum</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">10-star rating scale</p>
        </div>
        <div class="p-6">
            <x-accelade::infolist :infolist="$customMaxInfolist" />
        </div>
    </div>

    {{-- Different Sizes --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Different Sizes</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Rating icons in various sizes</p>
        </div>
        <div class="p-6">
            <x-accelade::infolist :infolist="$sizesInfolist" />
        </div>
    </div>

    {{-- Custom Colors --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Custom Colors</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Ratings with different color schemes</p>
        </div>
        <div class="p-6">
            <x-accelade::infolist :infolist="$colorsInfolist" />
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
                <x-accelade::rating-entry
                    label="Product Rating"
                    :value="4"
                    :max="5"
                />

                <x-accelade::rating-entry
                    label="Half Stars"
                    :value="3.5"
                    :max="5"
                    :allowHalf="true"
                />

                <x-accelade::rating-entry
                    label="Custom Size"
                    :value="4"
                    :max="5"
                    size="lg"
                    filledColor="success"
                />
            </div>
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">&lt;x-accelade::rating-entry
    label="Product Rating"
    :value="4"
    :max="5"
/&gt;

&lt;x-accelade::rating-entry
    label="Half Stars"
    :value="3.5"
    :max="5"
    :allowHalf="true"
/&gt;

&lt;x-accelade::rating-entry
    label="Custom Size"
    :value="4"
    :max="5"
    size="lg"
    filledColor="success"
/&gt;</x-accelade::code-block>
        </div>
    </div>
</div>

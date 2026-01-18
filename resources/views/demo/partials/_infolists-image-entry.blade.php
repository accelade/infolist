@php
    use Accelade\Infolists\Infolist;
    use Accelade\Infolists\Components\ImageEntry;
    use Accelade\Infolists\Components\Section;

    $data = [
        'avatar' => 'https://i.pravatar.cc/150?u=demo',
        'cover' => 'https://picsum.photos/seed/demo/800/400',
        'team' => [
            'https://i.pravatar.cc/150?u=1',
            'https://i.pravatar.cc/150?u=2',
            'https://i.pravatar.cc/150?u=3',
            'https://i.pravatar.cc/150?u=4',
            'https://i.pravatar.cc/150?u=5',
            'https://i.pravatar.cc/150?u=6',
        ],
        'gallery' => [
            'https://picsum.photos/seed/1/300/200',
            'https://picsum.photos/seed/2/300/200',
            'https://picsum.photos/seed/3/300/200',
            'https://picsum.photos/seed/4/300/200',
        ],
    ];

    // Basic image examples
    $basicInfolist = Infolist::make()
        ->record($data)
        ->columns(3)
        ->schema([
            ImageEntry::make('avatar')
                ->label('Square Image')
                ->square()
                ->size('xl'),

            ImageEntry::make('avatar')
                ->label('Circular Avatar')
                ->circular()
                ->size('xl'),

            ImageEntry::make('avatar')
                ->label('Rounded Image')
                ->size('xl'),
        ]);

    // Size variations
    $sizesInfolist = Infolist::make()
        ->record($data)
        ->columns(6)
        ->schema([
            ImageEntry::make('avatar')
                ->label('XS')
                ->circular()
                ->size('xs'),

            ImageEntry::make('avatar')
                ->label('SM')
                ->circular()
                ->size('sm'),

            ImageEntry::make('avatar')
                ->label('MD')
                ->circular()
                ->size('md'),

            ImageEntry::make('avatar')
                ->label('LG')
                ->circular()
                ->size('lg'),

            ImageEntry::make('avatar')
                ->label('XL')
                ->circular()
                ->size('xl'),

            ImageEntry::make('avatar')
                ->label('2XL')
                ->circular()
                ->size('2xl'),
        ]);

    // Stacked team avatars
    $stackedInfolist = Infolist::make()
        ->record($data)
        ->columns(2)
        ->schema([
            ImageEntry::make('team')
                ->label('Team Members (Stacked)')
                ->circular()
                ->stacked()
                ->limit(4)
                ->size('lg'),

            ImageEntry::make('team')
                ->label('All Team Members')
                ->circular()
                ->size('md'),
        ]);

    // Custom dimensions
    $customInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            ImageEntry::make('cover')
                ->label('Cover Image (Custom Dimensions)')
                ->width(600)
                ->height(250),
        ]);

    // Gallery with multiple images
    $galleryInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            ImageEntry::make('gallery')
                ->label('Photo Gallery')
                ->width(150)
                ->height(100),
        ]);

    // Lazy loading examples
    $lazyInfolist = Infolist::make()
        ->record($data)
        ->columns(3)
        ->schema([
            ImageEntry::make('avatar')
                ->label('Lazy (Default)')
                ->lazy()
                ->circular()
                ->size('xl'),

            ImageEntry::make('avatar')
                ->label('Eager Loading')
                ->eager()
                ->circular()
                ->size('xl'),

            ImageEntry::make('avatar')
                ->label('With Alt Text')
                ->alt('User profile avatar')
                ->circular()
                ->size('xl'),
        ]);

    // Picture tag example
    $pictureInfolist = Infolist::make()
        ->record($data)
        ->columns(1)
        ->schema([
            ImageEntry::make('cover')
                ->label('Responsive Image with Picture Tag')
                ->picture()
                ->sources([
                    ['srcset' => 'https://picsum.photos/seed/mobile/400/200', 'media' => '(max-width: 640px)'],
                    ['srcset' => 'https://picsum.photos/seed/tablet/600/300', 'media' => '(max-width: 1024px)'],
                ])
                ->alt('Cover image with responsive sources')
                ->width(800)
                ->height(400),
        ]);
@endphp

<div class="space-y-8">
    {{-- Basic Shapes --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Image Shapes</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Display images as square, circular, or rounded</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$basicInfolist" />
        </div>
    </div>

    {{-- Size Variations --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Size Variations</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Available sizes: xs, sm, md, lg, xl, 2xl</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$sizesInfolist" />
        </div>
    </div>

    {{-- Stacked Images --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Multiple & Stacked Images</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Display team avatars with stacking and overflow count</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$stackedInfolist" />
        </div>
    </div>

    {{-- Custom Dimensions --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Custom Dimensions</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Set explicit width and height for images</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$customInfolist" />
        </div>
    </div>

    {{-- Gallery --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Image Gallery</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Display multiple images in a gallery layout</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$galleryInfolist" />
        </div>
    </div>

    {{-- Lazy Loading & Alt Text --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Lazy Loading & Accessibility</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Optimize loading performance with lazy/eager loading and alt text</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$lazyInfolist" />
        </div>
    </div>

    {{-- Picture Tag --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Picture Tag for Responsive Images</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Use &lt;picture&gt; tag with multiple sources for art direction</p>
        </div>
        <div class="p-6">
            <x-infolists::infolist :infolist="$pictureInfolist" />
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
                <x-infolists::image-entry
                    label="Profile Photo"
                    value="https://i.pravatar.cc/150?u=blade"
                    alt="User profile photo"
                    :circular="true"
                    size="xl"
                />

                <x-infolists::image-entry
                    label="Eager Loading"
                    value="https://picsum.photos/seed/blade/200/200"
                    alt="Eagerly loaded image"
                    loading="eager"
                    :square="true"
                    size="lg"
                />

                <x-infolists::image-entry
                    label="Stacked Avatars"
                    :value="['https://i.pravatar.cc/150?u=a', 'https://i.pravatar.cc/150?u=b', 'https://i.pravatar.cc/150?u=c']"
                    alt="Team members"
                    :circular="true"
                    :stacked="true"
                    size="md"
                />

                @php
                    $pictureSources = [
                        ['srcset' => 'https://picsum.photos/seed/small/100/100', 'media' => '(max-width: 640px)'],
                    ];
                @endphp
                <x-infolists::image-entry
                    label="Picture Tag"
                    value="https://picsum.photos/seed/large/200/200"
                    alt="Responsive picture"
                    :picture="true"
                    :sources="$pictureSources"
                    size="xl"
                />
            </div>
        </div>
        <div class="p-6 pt-0">
            <x-accelade::code-block language="blade">@verbatim{{-- Basic with alt text --}}
<x-infolists::image-entry
    label="Profile Photo"
    value="https://example.com/avatar.jpg"
    alt="User profile photo"
    :circular="true"
    size="xl"
/>

{{-- Eager loading for above-fold images --}}
<x-infolists::image-entry
    label="Hero Image"
    value="https://example.com/hero.jpg"
    loading="eager"
    :square="true"
    size="lg"
/>

{{-- Stacked avatars with accessibility --}}
<x-infolists::image-entry
    label="Team"
    :value="['url1.jpg', 'url2.jpg', 'url3.jpg']"
    alt="Team members"
    :circular="true"
    :stacked="true"
    size="md"
/>

{{-- Responsive picture tag --}}
@php
$sources = [
    ['srcset' => '/img/mobile.webp', 'media' => '(max-width: 640px)', 'type' => 'image/webp'],
    ['srcset' => '/img/mobile.jpg', 'media' => '(max-width: 640px)'],
];
@endphp
<x-infolists::image-entry
    label="Responsive"
    value="/img/desktop.jpg"
    alt="Responsive image"
    :picture="true"
    :sources="$sources"
/>@endverbatim</x-accelade::code-block>
        </div>
    </div>
</div>

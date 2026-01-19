@props([
    'entry' => null,
    'value' => null,
    'label' => null,
    'helperText' => null,
    'maskCharacter' => '•',
    'maskLength' => null,
    'revealOnHover' => false,
    'revealOnClick' => true,
    'autoHideAfter' => null,
])

@php
    if ($entry) {
        // Object-based usage
        $maskedValue = $entry->getMaskedValue();
        $actualValue = $entry->getActualValue();
        $revealOnHover = $entry->isRevealOnHover();
        $revealOnClick = $entry->isRevealOnClick();
        $revealIcon = $entry->getRevealIcon();
        $hideIcon = $entry->getHideIcon();
        $autoHideAfter = $entry->getAutoHideAfter();
        $hasWrapper = true;
    } else {
        // Prop-based standalone usage
        $actualValue = $value;
        $maskedLength = $maskLength ?? ($actualValue ? strlen($actualValue) : 8);
        $maskedValue = str_repeat($maskCharacter, $maskedLength);
        $revealIcon = null;
        $hideIcon = null;
        $hasWrapper = false;
    }

    $uniqueId = 'secret-' . uniqid();
@endphp

@if ($hasWrapper && $entry)
    <x-accelade::entry-wrapper :entry="$entry">
        <div
            class="flex items-center gap-2"
            x-data="{
                revealed: false,
                masked: @js($maskedValue),
                actual: @js($actualValue),
                autoHideAfter: @js($autoHideAfter),
                timeout: null,
                toggle() {
                    this.revealed = !this.revealed;
                    if (this.revealed && this.autoHideAfter) {
                        clearTimeout(this.timeout);
                        this.timeout = setTimeout(() => {
                            this.revealed = false;
                        }, this.autoHideAfter * 1000);
                    }
                },
                init() {
                    @if ($revealOnHover)
                    this.$el.addEventListener('mouseenter', () => this.revealed = true);
                    this.$el.addEventListener('mouseleave', () => this.revealed = false);
                    @endif
                }
            }"
        >
            {{-- Secret value --}}
            <span
                class="font-mono text-gray-900 dark:text-white select-none"
                x-text="revealed ? actual : masked"
            >
                {{ $maskedValue }}
            </span>

            {{-- Toggle button --}}
            @if ($revealOnClick && $actualValue)
                <button
                    type="button"
                    class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 rounded"
                    @click="toggle()"
                    :title="revealed ? 'Hide' : 'Reveal'"
                >
                    <template x-if="!revealed">
                        @if ($revealIcon)
                            <x-dynamic-component
                                :component="$revealIcon"
                                class="w-5 h-5"
                            />
                        @else
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        @endif
                    </template>
                    <template x-if="revealed">
                        @if ($hideIcon)
                            <x-dynamic-component
                                :component="$hideIcon"
                                class="w-5 h-5"
                            />
                        @else
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        @endif
                    </template>
                </button>
            @endif
        </div>
    </x-accelade::entry-wrapper>
@else
    {{-- Standalone blade component usage --}}
    <div {{ $attributes->class(['accelade-entry']) }}>
        @if ($label)
            <div class="accelade-entry-label mb-1">
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</span>
            </div>
        @endif

        <div class="accelade-entry-content">
            <div
                class="flex items-center gap-2"
                x-data="{
                    revealed: false,
                    masked: @js($maskedValue),
                    actual: @js($actualValue),
                    autoHideAfter: @js($autoHideAfter),
                    timeout: null,
                    toggle() {
                        this.revealed = !this.revealed;
                        if (this.revealed && this.autoHideAfter) {
                            clearTimeout(this.timeout);
                            this.timeout = setTimeout(() => {
                                this.revealed = false;
                            }, this.autoHideAfter * 1000);
                        }
                    },
                    init() {
                        @if ($revealOnHover)
                        this.$el.addEventListener('mouseenter', () => this.revealed = true);
                        this.$el.addEventListener('mouseleave', () => this.revealed = false);
                        @endif
                    }
                }"
            >
                {{-- Secret value --}}
                <span
                    class="font-mono text-gray-900 dark:text-white select-none"
                    x-text="revealed ? actual : masked"
                >
                    {{ $maskedValue }}
                </span>

                {{-- Toggle button --}}
                @if ($revealOnClick && $actualValue)
                    <button
                        type="button"
                        class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 rounded"
                        @click="toggle()"
                        :title="revealed ? 'Hide' : 'Reveal'"
                    >
                        <template x-if="!revealed">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </template>
                        <template x-if="revealed">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </template>
                    </button>
                @endif
            </div>

            @if ($helperText)
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $helperText }}</p>
            @endif
        </div>
    </div>
@endif

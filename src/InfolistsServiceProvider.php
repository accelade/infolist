<?php

declare(strict_types=1);

namespace Accelade\Infolists;

use Accelade\Accelade;
use Accelade\Docs\DocsRegistry;
use Illuminate\Support\ServiceProvider;

class InfolistsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/infolists.php', 'infolists');

        $this->app->singleton('infolists', function () {
            return new Infolist;
        });
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'infolists');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/infolists.php' => config_path('infolists.php'),
            ], 'infolists-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/infolists'),
            ], 'infolists-views');

            $this->publishes([
                __DIR__.'/../dist' => public_path('vendor/infolists'),
            ], 'infolists-assets');
        }

        // Register infolist scripts with Accelade
        if ($this->app->bound('accelade')) {
            $this->registerScripts();
        }

        // Register documentation sections
        if ($this->app->bound('accelade.docs')) {
            $this->registerDocs();
        }
    }

    /**
     * Register infolist JavaScript and CSS with Accelade.
     */
    protected function registerScripts(): void
    {
        /** @var Accelade $accelade */
        $accelade = $this->app->make('accelade');

        // Register CSS styles
        $accelade->registerStyle('infolists', function () {
            $css = '';

            // First try dist CSS
            $distCssPath = __DIR__.'/../dist/accelade-infolists.css';
            if (file_exists($distCssPath)) {
                $css .= file_get_contents($distCssPath);
            }

            // Also include custom infolists.css if exists
            $customCssPath = __DIR__.'/../resources/css/infolists.css';
            if (file_exists($customCssPath)) {
                $css .= "\n".file_get_contents($customCssPath);
            }

            if ($css) {
                return "<style data-infolists-styles>\n{$css}\n</style>";
            }

            return '';
        });

        // Register JavaScript
        $accelade->registerScript('infolists', function () {
            // First try the built dist file
            $distPath = __DIR__.'/../dist/infolists.iife.js';
            if (file_exists($distPath)) {
                $js = file_get_contents($distPath);

                return "<script data-infolists-scripts>\n{$js}\n</script>";
            }

            // Fallback to minimal inline initialization
            return $this->getInlineInfolistsScripts();
        });
    }

    /**
     * Get inline infolists initialization scripts.
     */
    protected function getInlineInfolistsScripts(): string
    {
        return <<<'HTML'
<script data-infolists-scripts>
(function() {
    'use strict';

    // Infolist initialization
    function initInfolist() {
        initCopyable();
    }

    // Copyable functionality
    function initCopyable() {
        document.querySelectorAll('[data-copyable]').forEach(function(el) {
            if (el.dataset.copyableInitialized) return;
            el.dataset.copyableInitialized = 'true';

            el.addEventListener('click', function() {
                var text = el.dataset.copyableValue || el.textContent.trim();
                navigator.clipboard.writeText(text).then(function() {
                    // Show success feedback
                    var originalText = el.innerHTML;
                    el.innerHTML = '<span class="text-green-600 dark:text-green-400">Copied!</span>';
                    setTimeout(function() {
                        el.innerHTML = originalText;
                    }, 1500);
                });
            });
        });
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initInfolist);
    } else {
        initInfolist();
    }

    // Re-initialize on Accelade navigation events
    document.addEventListener('accelade:navigated', initInfolist);
    document.addEventListener('accelade:updated', initInfolist);

    // Export for manual use
    window.AcceladeInfolist = {
        init: initInfolist,
        initCopyable: initCopyable
    };
})();
</script>
HTML;
    }

    /**
     * Register documentation sections with the Accelade docs portal.
     */
    protected function registerDocs(): void
    {
        /** @var DocsRegistry $docs */
        $docs = $this->app->make('accelade.docs');

        // Register package docs path
        $docs->registerPackage('infolists', __DIR__.'/../docs');

        // Register navigation group
        $docs->registerGroup('infolists', 'Infolists', '📋', 40);

        // Register sections
        $docs->section('infolists-getting-started')
            ->label('Getting Started')
            ->icon('🚀')
            ->markdown('getting-started.md')
            ->package('infolists')
            ->description('Introduction to Accelade Infolists')
            ->keywords(['infolists', 'introduction', 'installation', 'setup'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-text-entry')
            ->label('Text Entry')
            ->icon('📝')
            ->markdown('text-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display text with formatting options')
            ->keywords(['text', 'entry', 'display', 'format', 'badge', 'copy'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-icon-entry')
            ->label('Icon Entry')
            ->icon('🎯')
            ->markdown('icon-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display icons with boolean mode')
            ->keywords(['icon', 'entry', 'boolean', 'status'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-image-entry')
            ->label('Image Entry')
            ->icon('🖼️')
            ->markdown('image-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display single or multiple images')
            ->keywords(['image', 'entry', 'avatar', 'photo', 'gallery'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-color-entry')
            ->label('Color Entry')
            ->icon('🎨')
            ->markdown('color-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display color swatches')
            ->keywords(['color', 'entry', 'swatch', 'hex', 'rgb'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-key-value-entry')
            ->label('Key Value Entry')
            ->icon('🔑')
            ->markdown('key-value-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display key-value pairs')
            ->keywords(['key', 'value', 'entry', 'table', 'metadata'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-repeatable-entry')
            ->label('Repeatable Entry')
            ->icon('🔄')
            ->markdown('repeatable-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display repeated data with nested schema')
            ->keywords(['repeatable', 'entry', 'nested', 'list', 'grid'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-badge-entry')
            ->label('Badge Entry')
            ->icon('🏷️')
            ->markdown('badge-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display values as styled badges with color mapping')
            ->keywords(['badge', 'entry', 'status', 'tag', 'label', 'color'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-code-entry')
            ->label('Code Entry')
            ->icon('💻')
            ->markdown('code-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display code snippets with syntax highlighting')
            ->keywords(['code', 'entry', 'syntax', 'highlight', 'snippet', 'json', 'php'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-qr-code-entry')
            ->label('QR Code Entry')
            ->icon('📱')
            ->markdown('qr-code-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display QR codes and barcodes')
            ->keywords(['qr', 'code', 'barcode', 'entry', 'scan'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-rating-entry')
            ->label('Rating Entry')
            ->icon('⭐')
            ->markdown('rating-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display ratings with stars or hearts')
            ->keywords(['rating', 'star', 'heart', 'score', 'entry'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-separator-entry')
            ->label('Separator Entry')
            ->icon('➖')
            ->markdown('separator-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display horizontal or vertical dividers')
            ->keywords(['separator', 'divider', 'hr', 'line', 'entry'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-html-entry')
            ->label('HTML Entry')
            ->icon('📄')
            ->markdown('html-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display HTML or Markdown content')
            ->keywords(['html', 'markdown', 'content', 'prose', 'entry'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-markdown-entry')
            ->label('Markdown Entry')
            ->icon('📝')
            ->markdown('markdown-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display markdown content with docs-style prose')
            ->keywords(['markdown', 'prose', 'content', 'gfm', 'github', 'entry'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-progress-entry')
            ->label('Progress Entry')
            ->icon('📊')
            ->markdown('progress-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display progress bars')
            ->keywords(['progress', 'bar', 'percentage', 'completion', 'entry'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-secret-entry')
            ->label('Secret Entry')
            ->icon('🔒')
            ->markdown('secret-entry.md')
            ->package('infolists')
            ->demo()
            ->description('Display masked sensitive data')
            ->keywords(['secret', 'password', 'masked', 'hidden', 'entry'])
            ->inGroup('infolists')
            ->register();

        $docs->section('infolists-api-reference')
            ->label('API Reference')
            ->icon('📚')
            ->markdown('api-reference.md')
            ->package('infolists')
            ->description('Complete API documentation')
            ->keywords(['api', 'reference', 'methods', 'options'])
            ->inGroup('infolists')
            ->register();
    }
}

@props([
    'entry' => null,
    'value' => null,
    'label' => null,
    'helperText' => null,
    'placeholder' => '—',
    'maxHeight' => null,
    'collapsible' => false,
    'collapsed' => false,
    'collapsedHeight' => '150px',
])

@php
    use League\CommonMark\Environment\Environment;
    use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
    use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
    use League\CommonMark\MarkdownConverter;

    if ($entry) {
        // Object-based usage
        $content = $entry->getFormattedContent();
        $maxHeight = $entry->getMaxHeight();
        $isCollapsible = $entry->isCollapsible();
        $isCollapsed = $entry->isCollapsed();
        $collapsedHeight = $entry->getCollapsedHeight();
        $placeholder = $entry->getPlaceholder() ?? '—';
        $hasWrapper = true;
    } else {
        // Prop-based standalone usage
        $isCollapsible = $collapsible;
        $isCollapsed = $collapsed;
        $hasWrapper = false;

        if ($value) {
            // Parse markdown using CommonMark
            $environment = new Environment([
                'html_input' => 'allow',
                'allow_unsafe_links' => false,
            ]);
            $environment->addExtension(new CommonMarkCoreExtension);
            $environment->addExtension(new GithubFlavoredMarkdownExtension);
            $converter = new MarkdownConverter($environment);
            $content = $converter->convert($value)->getContent();
        } else {
            $content = null;
        }
    }

    $uniqueId = 'markdown-' . uniqid();
@endphp

{{-- Docs-prose styles matching the documentation layout --}}
@once
@push('styles')
<style>
    .infolist-markdown-prose {
        font-size: 1rem;
        line-height: 1.75;
        color: var(--docs-text, #0f172a);
        word-wrap: break-word;
    }

    /* Headings */
    .infolist-markdown-prose h1,
    .infolist-markdown-prose h2,
    .infolist-markdown-prose h3,
    .infolist-markdown-prose h4,
    .infolist-markdown-prose h5,
    .infolist-markdown-prose h6 {
        margin-top: 1.5em;
        margin-bottom: 1rem;
        font-weight: 600;
        line-height: 1.25;
        color: var(--docs-text, #0f172a);
    }
    .infolist-markdown-prose h1 { font-size: 2em; padding-bottom: 0.3em; border-bottom: 1px solid var(--docs-border, #e2e8f0); margin-top: 0; }
    .infolist-markdown-prose h2 { font-size: 1.5em; padding-bottom: 0.3em; border-bottom: 1px solid var(--docs-border, #e2e8f0); }
    .infolist-markdown-prose h3 { font-size: 1.25em; }
    .infolist-markdown-prose h4 { font-size: 1em; }
    .infolist-markdown-prose h5 { font-size: 0.875em; }
    .infolist-markdown-prose h6 { font-size: 0.85em; color: var(--docs-text-muted, #64748b); }

    /* Paragraphs */
    .infolist-markdown-prose p {
        margin-top: 0;
        margin-bottom: 1em;
    }

    /* Links */
    .infolist-markdown-prose a {
        color: var(--docs-accent, #ea7023);
        text-decoration: none;
    }
    .infolist-markdown-prose a:hover {
        text-decoration: underline;
    }

    /* Bold and emphasis */
    .infolist-markdown-prose strong { font-weight: 600; color: var(--docs-text, #0f172a); }
    .infolist-markdown-prose em { font-style: italic; }

    /* Inline code */
    .infolist-markdown-prose code {
        padding: 0.2em 0.4em;
        margin: 0;
        font-size: 85%;
        font-family: 'JetBrains Mono', ui-monospace, SFMono-Regular, 'SF Mono', Menlo, Consolas, monospace;
        background-color: var(--docs-bg-alt, #f8fafc);
        border-radius: 6px;
        border: 1px solid var(--docs-border, #e2e8f0);
    }
    .infolist-markdown-prose pre code {
        padding: 0;
        margin: 0;
        font-size: 100%;
        background-color: transparent;
        border: none;
        border-radius: 0;
    }

    /* Code blocks */
    .infolist-markdown-prose pre {
        padding: 1rem;
        overflow: auto;
        font-size: 0.875rem;
        line-height: 1.45;
        background-color: var(--docs-bg-alt, #f8fafc);
        border-radius: 6px;
        border: 1px solid var(--docs-border, #e2e8f0);
        margin-top: 0;
        margin-bottom: 1rem;
    }

    /* Lists */
    .infolist-markdown-prose ul,
    .infolist-markdown-prose ol {
        margin-top: 0;
        margin-bottom: 1rem;
        padding-inline-start: 2em;
    }
    .infolist-markdown-prose ul { list-style-type: disc; }
    .infolist-markdown-prose ol { list-style-type: decimal; }
    .infolist-markdown-prose ul ul,
    .infolist-markdown-prose ol ol,
    .infolist-markdown-prose ul ol,
    .infolist-markdown-prose ol ul {
        margin-top: 0.25em;
        margin-bottom: 0;
    }
    .infolist-markdown-prose li {
        margin-bottom: 0.25em;
    }
    .infolist-markdown-prose li + li {
        margin-top: 0.25em;
    }
    .infolist-markdown-prose li > p {
        margin-top: 1em;
    }
    .infolist-markdown-prose li > ul,
    .infolist-markdown-prose li > ol {
        margin-top: 0.25em;
    }

    /* Task lists (checkboxes) */
    .infolist-markdown-prose input[type="checkbox"] {
        margin-inline-end: 0.5em;
        vertical-align: middle;
    }

    /* Blockquotes */
    .infolist-markdown-prose blockquote {
        margin: 0 0 1rem 0;
        padding: 0 1em;
        color: var(--docs-text-muted, #64748b);
        border-inline-start: 0.25em solid var(--docs-border, #e2e8f0);
    }
    .infolist-markdown-prose blockquote > :first-child { margin-top: 0; }
    .infolist-markdown-prose blockquote > :last-child { margin-bottom: 0; }

    /* Horizontal rules */
    .infolist-markdown-prose hr {
        height: 2px;
        padding: 0;
        margin: 2rem 0;
        background: linear-gradient(to right, transparent, var(--docs-border, #e2e8f0), transparent);
        border: 0;
    }

    /* Tables */
    .infolist-markdown-prose table {
        display: block;
        width: 100%;
        max-width: 100%;
        overflow: auto;
        border-spacing: 0;
        border-collapse: collapse;
        margin-top: 0;
        margin-bottom: 1rem;
    }
    .infolist-markdown-prose table th,
    .infolist-markdown-prose table td {
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--docs-border, #e2e8f0);
    }
    .infolist-markdown-prose table th {
        font-weight: 600;
        background-color: var(--docs-bg-alt, #f8fafc);
        text-align: start;
    }
    .infolist-markdown-prose table tr {
        background-color: var(--docs-bg, #ffffff);
        border-top: 1px solid var(--docs-border, #e2e8f0);
    }
    .infolist-markdown-prose table tr:nth-child(2n) {
        background-color: var(--docs-bg-alt, #f8fafc);
    }

    /* Images */
    .infolist-markdown-prose img {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
        margin: 1rem 0;
    }

    /* Definition lists */
    .infolist-markdown-prose dl {
        padding: 0;
        margin-bottom: 1rem;
    }
    .infolist-markdown-prose dl dt {
        padding: 0;
        margin-top: 1rem;
        font-weight: 600;
    }
    .infolist-markdown-prose dl dd {
        padding: 0 1rem;
        margin-bottom: 1rem;
        margin-inline-start: 0;
    }

    /* Keyboard keys */
    .infolist-markdown-prose kbd {
        display: inline-block;
        padding: 0.2em 0.4em;
        font-size: 0.875em;
        font-family: 'JetBrains Mono', monospace;
        line-height: 1;
        color: var(--docs-text, #0f172a);
        vertical-align: middle;
        background-color: var(--docs-bg-alt, #f8fafc);
        border: 1px solid var(--docs-border, #e2e8f0);
        border-radius: 6px;
        box-shadow: inset 0 -1px 0 var(--docs-border, #e2e8f0);
    }

    /* Abbreviations */
    .infolist-markdown-prose abbr[title] {
        text-decoration: underline dotted;
        cursor: help;
        border-bottom: none;
    }

    /* First child and last child cleanup */
    .infolist-markdown-prose > :first-child { margin-top: 0 !important; }
    .infolist-markdown-prose > :last-child { margin-bottom: 0 !important; }

    /* Collapsible state */
    .infolist-markdown-collapsed {
        position: relative;
        overflow: hidden;
    }
    .infolist-markdown-collapsed::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60px;
        background: linear-gradient(to bottom, transparent, var(--docs-bg, #ffffff));
        pointer-events: none;
    }
</style>
@endpush
@endonce

@if ($hasWrapper && $entry)
    <x-infolists::entry-wrapper :entry="$entry">
        @if ($content)
            @if ($isCollapsible)
                <div
                    id="{{ $uniqueId }}"
                    class="infolist-markdown-prose {{ $isCollapsed ? 'infolist-markdown-collapsed' : '' }}"
                    style="{{ $isCollapsed ? 'max-height: ' . $collapsedHeight . ';' : '' }}{{ $maxHeight && !$isCollapsed ? 'max-height: ' . $maxHeight . '; overflow-y: auto;' : '' }}"
                    data-collapsed-height="{{ $collapsedHeight }}"
                    data-max-height="{{ $maxHeight }}"
                >
                    {!! $content !!}
                </div>
                <button
                    type="button"
                    onclick="toggleMarkdownCollapse('{{ $uniqueId }}')"
                    class="mt-2 text-sm font-medium transition-colors"
                    style="color: var(--docs-accent, #ea7023);"
                >
                    <span id="{{ $uniqueId }}-text">{{ $isCollapsed ? 'Show more' : 'Show less' }}</span>
                </button>
                <script>
                    function toggleMarkdownCollapse(id) {
                        var el = document.getElementById(id);
                        var textEl = document.getElementById(id + '-text');
                        var isCollapsed = el.classList.contains('infolist-markdown-collapsed');
                        var collapsedHeight = el.dataset.collapsedHeight;
                        var maxHeight = el.dataset.maxHeight;

                        if (isCollapsed) {
                            el.classList.remove('infolist-markdown-collapsed');
                            el.style.maxHeight = maxHeight || 'none';
                            el.style.overflowY = maxHeight ? 'auto' : '';
                            textEl.textContent = 'Show less';
                        } else {
                            el.classList.add('infolist-markdown-collapsed');
                            el.style.maxHeight = collapsedHeight;
                            el.style.overflowY = '';
                            textEl.textContent = 'Show more';
                        }
                    }
                </script>
            @else
                <div
                    class="infolist-markdown-prose"
                    @if ($maxHeight) style="max-height: {{ $maxHeight }}; overflow-y: auto;" @endif
                >
                    {!! $content !!}
                </div>
            @endif
        @else
            <span style="color: var(--docs-text-muted, #64748b); font-style: italic;">
                {{ $placeholder }}
            </span>
        @endif
    </x-infolists::entry-wrapper>
@else
    {{-- Standalone blade component usage --}}
    <div {{ $attributes->class(['accelade-entry']) }}>
        @if ($label)
            <div class="accelade-entry-label mb-1">
                <span class="text-sm font-medium" style="color: var(--docs-text-muted, #64748b);">{{ $label }}</span>
            </div>
        @endif

        <div class="accelade-entry-content">
            @if ($content)
                @if ($isCollapsible)
                    <div
                        id="{{ $uniqueId }}"
                        class="infolist-markdown-prose {{ $isCollapsed ? 'infolist-markdown-collapsed' : '' }}"
                        style="{{ $isCollapsed ? 'max-height: ' . $collapsedHeight . ';' : '' }}{{ $maxHeight && !$isCollapsed ? 'max-height: ' . $maxHeight . '; overflow-y: auto;' : '' }}"
                        data-collapsed-height="{{ $collapsedHeight }}"
                        data-max-height="{{ $maxHeight }}"
                    >
                        {!! $content !!}
                    </div>
                    <button
                        type="button"
                        onclick="toggleMarkdownCollapse('{{ $uniqueId }}')"
                        class="mt-2 text-sm font-medium transition-colors"
                        style="color: var(--docs-accent, #ea7023);"
                    >
                        <span id="{{ $uniqueId }}-text">{{ $isCollapsed ? 'Show more' : 'Show less' }}</span>
                    </button>
                @else
                    <div
                        class="infolist-markdown-prose"
                        @if ($maxHeight) style="max-height: {{ $maxHeight }}; overflow-y: auto;" @endif
                    >
                        {!! $content !!}
                    </div>
                @endif
            @else
                <span style="color: var(--docs-text-muted, #64748b); font-style: italic;">{{ $placeholder }}</span>
            @endif

            @if ($helperText)
                <p class="mt-1 text-xs" style="color: var(--docs-text-muted, #64748b);">{{ $helperText }}</p>
            @endif
        </div>
    </div>
@endif

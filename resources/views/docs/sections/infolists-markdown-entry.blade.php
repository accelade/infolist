@props(['framework' => 'vanilla', 'prefix' => 'a', 'documentation' => null, 'hasDemo' => true])

<x-accelade::layouts.docs :framework="$framework" section="infolists-markdown-entry" :documentation="$documentation" :hasDemo="$hasDemo">
    @include('infolists::demo.partials._infolists-markdown-entry')
</x-accelade::layouts.docs>

@props(['framework' => 'vanilla', 'prefix' => 'a', 'documentation' => null, 'hasDemo' => true])

<x-accelade::layouts.docs :framework="$framework" section="infolists-qr-code-entry" :documentation="$documentation" :hasDemo="$hasDemo">
    @include('infolists::demo.partials._infolists-qr-code-entry')
</x-accelade::layouts.docs>

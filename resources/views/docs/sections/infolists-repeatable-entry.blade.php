@props(['framework' => 'vanilla', 'prefix' => 'a', 'documentation' => null, 'hasDemo' => true])

<x-accelade::layouts.docs :framework="$framework" section="infolists-repeatable-entry" :documentation="$documentation" :hasDemo="$hasDemo">
    @include('infolists::demo.partials._infolists-repeatable-entry')
</x-accelade::layouts.docs>

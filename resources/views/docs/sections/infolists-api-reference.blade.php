@props(['framework' => 'vanilla', 'prefix' => 'a', 'documentation' => null, 'hasDemo' => false])

<x-accelade::layouts.docs :framework="$framework" section="infolists-api-reference" :documentation="$documentation" :hasDemo="$hasDemo">
    {{-- No demo for API reference --}}
</x-accelade::layouts.docs>

@props(['framework' => 'vanilla', 'prefix' => 'a', 'documentation' => null, 'hasDemo' => false])

<x-accelade::layouts.docs :framework="$framework" section="infolists-getting-started" :documentation="$documentation" :hasDemo="$hasDemo">
    {{-- No demo for getting started --}}
</x-accelade::layouts.docs>

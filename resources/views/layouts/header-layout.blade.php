@props(['headerActions' => ''])
<x-base-layout
    :title="$title" :override-title="$overrideTitle"
>
    <div class="flex flex-col min-h-screen">
        <x-header :header-title="$headerTitle">
            {{$headerActions}}
        </x-header>
        <main class="flex-1 ">
            {{$slot}}
        </main>
        <x-footer/>
    </div>
</x-base-layout>

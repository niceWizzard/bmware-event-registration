<x-base-layout title="Wow" >
    <h2 class="text-lg font-bold text-red-600">
        LKSJDFLKJS
    </h2>
    <div x-data="{ count: 0 }">
        <button @click="count++">Add</button>
        <span x-text="count"></span>
    </div>
</x-base-layout>

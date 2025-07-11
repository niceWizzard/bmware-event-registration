@props(['class' => ''])

<x-base-layout :title="$title" :override-title="$overrideTitle">
    <main class="min-h-screen bg-surface flex items-center justify-center px-4">
        <div
            class="card card-border bg-base-100 min-w-96"
        >
            <div class="{{twMerge(['card-body', $class])}}">
                <h2 class="{{twMerge(['card-title', $cardTitleClass])}}">{{$cardTitle}}</h2>
                {{ $slot }}
            </div>
        </div>
    </main>
</x-base-layout>

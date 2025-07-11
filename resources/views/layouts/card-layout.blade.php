<x-base-layout :title="$title" :override-title="$overrideTitle">
    <main class="min-h-screen bg-surface flex items-center justify-center px-4">
        <div
            class="card card-border bg-base-100 w-96"
        >
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    </main>
</x-base-layout>

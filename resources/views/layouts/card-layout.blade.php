<x-base-layout :title="$title" :override-title="$overrideTitle">
    <main class="min-h-screen bg-surface flex items-center justify-center px-4">
        <div
            class="w-full max-w-md rounded-2xl shadow-lg border border-outline bg-surface text-on-surface p-6 space-y-4"
        >
            {{-- Content slot --}}
            <div class="text-base text-on-surface">
                {{ $slot }}
            </div>
        </div>
    </main>
</x-base-layout>

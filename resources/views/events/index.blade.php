@php
    use \Illuminate\Support\Str;
@endphp

<x-header-layout title="Events">
    <section class="p-8 grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 container mx-auto">
        @foreach($events as $event)
            <a
                class="flex flex-col justify-between bg-[var(--color-surface-alt)] text-[var(--color-on-surface)] border border-[var(--color-outline)] hover:shadow-lg transition-shadow duration-300 rounded-[var(--radius-radius)] overflow-hidden p-4 min-h-[10rem]"
                href="{{ route('events.show', $event->slug) }}"
            >
                <div class="space-y-2">
                    <h3 class="text-base font-semibold text-[var(--color-on-surface-strong)] hover:underline">
                        {{ Str::limit($event->title, 36) }}
                    </h3>
                    <small class="text-xs text-[var(--color-on-surface)]"
                           data-time="{{ $event->created_at->toIso8601String() }}">
                        {{-- JS will localize this --}}
                        {{ $event->created_at->format('D, h:i A') }}
                    </small>
                    <p class="text-sm text-[var(--color-on-surface)]">
                        {{ Str::limit($event->description, 72) }}
                    </p>
                </div>
            </a>
        @endforeach
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('small[data-time]').forEach(el => {
                const raw = el.dataset.time;
                const date = new Date(raw);
                el.textContent = new Intl.DateTimeFormat(navigator.language, {
                    weekday: 'short',
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true,
                }).format(date);
            });
        });
    </script>
</x-header-layout>

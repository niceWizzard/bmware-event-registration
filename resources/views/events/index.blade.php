@php
    use \Illuminate\Support\Str;
@endphp

<x-header-layout title="Events">
    <section class="p-8 w-full gap-6 flex flex-col container mx-auto">
        <div class="flex flex-wrap gap-4">
            @foreach($events as $event)
                <div
                    class="card card-border w-sm"
                >
                    <div class="card-body">
                        <span class="badge badge-{{strtolower($event->status)}}">
                            {{$event->status}}
                        </span>
                        <h3 class="card-title">
                            <a href="{{route('events.show', $event->short_name)}}">
                                {{Str::limit($event->title, 64)}}
                            </a>
                        </h3>
                        <p class="text-sm font-light">{{ $event->created_at?->format('D, h:i A') }}</p>
                        <div class="card-actions justify-end items-center">
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-700">
                                    {{ number_format($event->registrations_count ?? 0) }} <span class="text-gray-500">Registrations</span>
                                </span>
                            </div>
                            <a href="{{route('events.show', $event->short_name)}}" class="btn btn-primary">
                                <x-fas-eye class="size-4"/>
                                View
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $events->links('pagination::default') }}
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

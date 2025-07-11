@php
    use \Illuminate\Support\Facades\Cookie;
    $registrationCookie = Cookie::get('event_'.$event->id);
@endphp
<x-header-layout title="Event" link-to="{{route('home')}}">
    @auth
        <x-slot:headerActions>
            <a class="hover:underline" href="{{route('home')}}">Edit</a>
            <a class="hover:underline" href="{{route('home')}}">Manage</a>
        </x-slot:headerActions>
    @endauth
    <section
        class="container mx-auto my-6 p-6 space-y-6  rounded-radius text-on-surface ">
        {{-- Banner --}}
        @if ($event->banner)
            <div class="overflow-hidden rounded-radius shadow">
                <img src="{{ $event->banner_url }}" alt="{{ $event->title }}" class="w-full h-64 object-cover"/>
            </div>
        @endif
        <a href="#register" class="underline">Register now</a>
        {{-- Title + Meta --}}
        <div>
            <h1 class="text-2xl font-semibold text-on-surface-strong">{{ $event->title }}</h1>
            <p class="text-sm text-[var(--color-on-surface)]" data-time="{{ $event->created_at?->toIso8601String() }}">
                Created: {{ $event->created_at?->format('D, h:i A') }}
            </p>
        </div>

        {{-- Description --}}
        @if ($event->description)
            <div>
                <h2 class="text-lg font-medium text-on-surface-strong">Description</h2>
                <br>
                {!! $event->description !!}
            </div>
        @endif

        {{-- Event Details --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div
                class="card card-border">
                <div class="card-body">
                    <h3 class="card-title">Venue</h3>
                    <p>{{ $event->venue }}</p>
                </div>
            </div>
            <div
                class="card card-border">
                <div class="card-body">
                    <h3 class="card-title">Partner</h3>
                    <p>{{ $event->partner }}</p>
                </div>
            </div>
            <div
                class="card card-border">
                <div class="card-body">
                    <h3 class="card-title">Event Period</h3>
                    <p>
                        <span data-time="{{ $event->start_date }}">{{ $event->start_date }}</span>
                        to <span data-time="{{ $event->end_date }}">{{ $event->end_date }}</span>
                    </p>
                </div>
            </div>
            <div
                class="card card-border">
                <div class="card-body">
                    <h3 class="card-title">Registration Period</h3>
                    <p>
                        <span
                            data-time="{{ $event->registration_start_date }}">{{ $event->registration_start_date }}</span>
                        to <span
                            data-time="{{ $event->registration_end_date}}">{{ $event->registration_end_date }}</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="flex flex-col gap-2 w-full">
            @if(is_null($registrationCookie))
                <h3 class="text-lg text-center " id="register">Register now!</h3>
                <x-registration-form action="{{route('events.register', $event->slug)}}"/>
            @else
                <h3 class="text-lg text-center font-bold" id="register">
                    You already registered in this event
                </h3>
                @if(session('message'))
                    <p class="text-danger">
                        {{session('message')}}
                    </p>
                @endif
                <form
                    class="flex justify-center gap-2"
                    method="POST"
                    action="{{route('events.clear', $event->slug)}}"
                >
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Register new
                    </button>
                    <a href="{{route('events.show-qr', [$event->slug, $registrationCookie])}}"
                       class="btn btn-secondary">
                        View QR Code
                    </a>
                </form>

            @endif
        </div>
    </section>

    {{-- Localize all date/times using browser locale --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-time]').forEach(el => {
                const raw = el.dataset.time;
                if (!raw) return;
                const date = new Date(raw);
                el.textContent = new Intl.DateTimeFormat(navigator.language, {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                }).format(date);
            });
        });
    </script>
</x-header-layout>

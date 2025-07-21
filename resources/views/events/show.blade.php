@php
    use \Illuminate\Support\Facades\Cookie;
    $registrationCookie = Cookie::get('event_'.$event->id);

    $breadcrumbs = [
        [
            'link' => route('events.index'),
            'text' => 'Events',
        ],
        [
            'text' => 'Show',
        ],
    ];
@endphp
<x-header-layout title="Event" link-to="{{route('home')}}">
    @auth
        @if($event->is_private)
            <div
                class="flex w-full sticky z-10 top-0 bg-secondary text-secondary-content p-1 gap-2 justify-center items-center">
                <p class="text-center">This is a private event!</p>
                <form action="{{route('events.as-public', $event->short_name)}}"
                      method="POST"
                >
                    @method('PATCH')
                    @csrf
                    <button class="btn btn-accent btn-sm">Make public</button>
                </form>
            </div>
        @endif
        <x-slot:headerActions>
            <a class="hover:underline"
               href="{{route('events.registrations.show', $event->short_name)}}">Registrations</a>
            <a class="hover:underline" href="{{route('events.edit', $event->short_name)}}">Edit</a>
            <a class="hover:underline" href="{{route('events.manage', $event->short_name)}}">Manage</a>
        </x-slot:headerActions>
    @endauth
    <section
        class="container mx-auto my-6 p-6 space-y-6  rounded-radius text-on-surface ">
        @auth
            <x-breadcrumb :breadcrumbs="$breadcrumbs" class="text-lg font-medium"/>
        @endauth
        {{-- Banner --}}
        @if ($event->banner)
            <div class="">
                <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->title }}"
                     class="w-full h-64 object-contain"/>
            </div>
        @endif
        <a href="#register" class="underline">Register now</a>
        {{-- Title + Meta --}}
        <div>
            <h1 class="text-3xl font-semibold text-on-surface-strong">{{ $event->title }}</h1>
            <p class="text-sm text-[var(--color-on-surface)]">
                Created:<span data-time="true"> {{ $event->created_at->toString()}}</span>
            </p>
        </div>

        {{-- Description --}}
        @if ($event->body)
            <div class="body">
                <br>
                {!! $event->body !!}
            </div>
        @endif

        {{-- Event Details --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="card bg-base-100  card-border w-full max-w-md mx-auto max-h-96">
                @if($event->venue_picture)
                    <figure>
                        <img src="{{ asset('storage/' . $event->venue_picture) }}"
                             alt="{{ $event->title }}"
                        />
                    </figure>
                @endif

                <div class="card-body space-y-2">
                    <div class="flex items-center gap-2">
                        <x-akar-location class="size-8"/>
                        <h3 class="card-title text-base-content">Venue</h3>
                    </div>
                    <p class="text-base-content text-sm">{{ $event->venue }}</p>
                </div>
            </div>
            <div class="card bg-base-100  card-border w-full max-w-md mx-auto max-h-96">
                @if($event->partner_picture)
                    <figure>
                        <img src="{{ asset('storage/' . $event->partner_picture) }}"
                             alt="{{ $event->title }}"
                             class="w-full h-full object-cover object-center"/>
                    </figure>
                @endif

                <div class="card-body space-y-2">
                    <div class="flex items-center gap-2">
                        <x-akar-people-group class="size-8"/>
                        <h3 class="card-title text-base-content">Partner</h3>
                    </div>
                    <p class="text-base-content text-sm">{{ $event->partner }}</p>
                </div>
            </div>
            <div
                class="card card-border w-full max-w-md mx-auto">
                <div class="card-body">
                    <div class="flex gap-2 mb-2">
                        <x-akar-calendar class="size-8"/>
                        <h3 class="card-title">Event Period</h3>
                    </div>
                    <p>
                        <span data-time="true">{{ $event->start_date->toString() }}</span>
                        to <span data-time="true">{{ $event->end_date->toString() }}</span>
                    </p>
                </div>
            </div>
            <div
                class="card card-border w-full max-w-md mx-auto">
                <div class="card-body">
                    <div class="flex gap-2 mb-2">
                        <x-akar-edit class="size-8"/>
                        <h3 class="card-title">Registration Period</h3>
                    </div>
                    <p>
                        <span
                            data-time="true">{{ $event->registration_start_date->toString() }}</span>
                        to <span
                            data-time="true">{{ $event->registration_end_date->toString() }}</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="flex flex-col gap-2 w-full" id="register">
            @if($event->can_register)
                @if(is_null($registrationCookie))
                    <h3 class="text-lg text-center ">Register now!</h3>
                    <x-registration-form action="{{route('events.register', $event->short_name)}}"/>
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
                        action="{{route('events.clear', $event->short_name)}}"
                    >
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Register new
                        </button>
                        <a href="{{route('events.show-qr', [$event->short_name, $registrationCookie])}}"
                           class="btn btn-secondary">
                            View QR Code
                        </a>
                    </form>
                @endif
            @else
                <h3 class="text-center">
                    @if($event->registration_start_date->gt(now()))
                        Registration will start at <span
                            data-time="true">{{$event->registration_start_date->toString()}}</span>
                    @else
                        Registration Period Ended
                    @endif
                </h3>
            @endif
        </div>
    </section>

    {{-- Localize all date/times using browser locale --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.transformDataTime();
        });
    </script>
</x-header-layout>

@php use Illuminate\Support\Str; @endphp
<x-header-layout title="" link-to="{{route('home')}}">
    <x-slot:headerActions>
        @auth
            <a href="{{route('events.index')}}">
                Events
            </a>
        @endauth
        @guest
            <a href="{{route('login')}}">
                Login
            </a>
        @endguest
    </x-slot:headerActions>
    <div class="p-8">
        <section class="bg-primary text-primary-content py-20 px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl font-bold mb-4">Welcome to Event Registration</h2>
                <p class="text-lg mb-6">Discover and register amazing events effortlessly.</p>
                <a href="{{route('events.index')}}"
                   class="btn btn-lg">Explore
                    Events</a>
            </div>
        </section>

        <!-- Featured Section -->
        <section id="events" class="py-16 px-6 bg-gray-100">
            <div class="max-w-5xl mx-auto">
                <h3 class="text-2xl font-bold text-center text-primary-700 mb-10">Upcoming Events</h3>
                @if(!count($upcomingEvents))
                    <p class="text-center w-full ">
                        No events yet.
                    </p>
                @endif
                <div class="grid md:grid-cols-3 gap-8 place-content-center ">
                    @foreach($upcomingEvents as $event)
                        <a href="{{route('events.show', $event->short_name)}}" class="card shadow-sm bg-white">
                            <div class="card-body">
                                <h3 class="card-title">
                                    {{Str::limit($event->title, 36)}}
                                </h3>
                                <span class="text-xs block mt-2">
                                    {{$event->start_date->format('M d - ')}}
                                    {{$event->end_date->format('d, Y')}}
                                </span>
                                <p class="text-base font-light">
                                    {{Str::limit($event->description, 72)}}
                                </p>
                            </div>
                        </a>
                    @endforeach

                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-16 px-6 bg-base-100">
            <div class="max-w-3xl mx-auto text-center">
                <h3 class="text-xl font-bold text-primary-700 mb-4">Why Event Registration?</h3>
                <p class="text-gray-600 leading-relaxed">
                    Eventify makes it easy for you to find and register for events that matter to you. Whether you're
                    looking to learn, connect, or showcase, our platform brings everything under one roof.
                </p>
            </div>
        </section>
    </div>
</x-header-layout>

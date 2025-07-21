@php
    use \Illuminate\Support\Str;
    $breadcrumbs = [
        [
            'link' => route('events.index'),
            'text' => 'Events',
        ],
    ];
@endphp

<x-auth-layout>
    <section class="p-8 gap-2 container mx-auto flex flex-col">
        @auth
            <div class="flex justify-end w-full">
                <a href="{{route('events.create')}}" class="btn btn-primary">
                    <x-fas-plus class="size-4"/>
                    Create Event
                </a>
            </div>
        @endauth
        <div class="flex flex-col md:flex-row md:justify-between gap-4">
            <!-- Breadcrumb on top or left -->
            <x-breadcrumb :breadcrumbs="$breadcrumbs" class="text-lg font-medium"/>

            <!-- Filters (responsive) -->
            <div
                x-data="{
            sort: '{{ request('sort', '') }}',
            order: '{{ request('order', 'desc') }}',
            visibility: '{{ request('visibility', '') }}',
            status: '{{ request('status', '') }}',
            updateUrl() {
                const url = new URL(window.location.href);

                if (this.sort) url.searchParams.set('sort', this.sort); else url.searchParams.delete('sort');
                if (this.order) url.searchParams.set('order', this.order); else url.searchParams.delete('order');
                if (this.visibility) url.searchParams.set('visibility', this.visibility); else url.searchParams.delete('visibility');
                if (this.status) url.searchParams.set('status', this.status); else url.searchParams.delete('status');

                url.searchParams.delete('page');
                window.location.href = url.toString();
            }
        }"
                class="flex flex-col sm:flex-row flex-wrap gap-2 items-stretch md:items-center justify-end"
            >
                <!-- Status -->
                <select x-model="status" @change="updateUrl()" class="select w-full sm:w-auto">
                    <option value="">All Status</option>
                    <option value="Pending">Pending</option>
                    <option value="On-Going">On-Going</option>
                    <option value="Ended">Ended</option>
                </select>

                @auth
                    <!-- Visibility -->
                    <select x-model="visibility" @change="updateUrl()" class="select w-full sm:w-auto">
                        <option value="">All Visibility</option>
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                    </select>
                @endauth

                <!-- Sort -->
                <select x-model="sort" @change="updateUrl()" class="select w-full sm:w-auto">
                    <option disabled value="">Sort by</option>
                    <option value="start_date">Event Start Date</option>
                    <option value="registration_start_date">Registration Start Date</option>
                    <option value="registrations">Registration Count</option>
                </select>

                <!-- Order Toggle -->
                <button
                    type="button"
                    class="btn btn-outline w-full sm:w-auto"
                    @click="order = (order === 'asc' ? 'desc' : 'asc'); updateUrl()"
                >
                    <x-fas-arrow-up x-show="order === 'asc'" class="w-4 h-4"/>
                    <x-fas-arrow-down x-show="order === 'desc'" class="w-4 h-4"/>
                    <span class="ml-2 capitalize" x-text="order"></span>
                </button>
            </div>
        </div>
        <form method="GET" class="mb-4">
            <div class="flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search events by title"
                    class="input input-bordered w-full max-w-xs"
                />

                <button type="submit" class="btn btn-primary">
                    Search
                </button>

                @if(request('search'))
                    <a href="{{ url()->current() }}" class="btn btn-ghost">
                        Clear
                    </a>
                @endif
            </div>
        </form>

        <div class="flex flex-wrap justify-center  gap-2">
            @forelse($events as $event)
                <x-event-card :event="$event"/>
            @empty
                <p class="text-lg">No events...</p>
            @endforelse
        </div>
        {{ $events->links('pagination::default') }}
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.transformDataTime();
        });
    </script>
</x-auth-layout>

@php
    $breadcrumbs = [
            [
                'link' => route('events.index'),
                'text' => 'Events',
            ],
            [
                'link' => route('events.show', $event->short_name),
                'text' => \Illuminate\Support\Str::limit($event->title, 24),
            ],
            [
                'text' => 'Registrations',
            ],
    ];
    function sort_link($column) {
    $currentSort = request('sort');
    $currentDirection = request('direction', 'asc');
    $isActive = $currentSort === $column;
    $nextDirection = ($isActive && $currentDirection === 'asc') ? 'desc' : 'asc';

    $query = array_merge(request()->query(), ['sort' => $column, 'direction' => $nextDirection]);
    return url()->current() . '?' . http_build_query($query);
}

@endphp
<x-auth-layout>
    <section class="mx-auto container p-8 flex flex-col gap-2">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" class="text-lg font-medium"/>
        <div class="w-full flex justify-end gap-2">
            <a href="{{route('events.manage', $event->short_name)}}" class="btn btn-secondary">Manage</a>
        </div>
        <h3 class="text-lg">Showing {{$registrations->total()}} of {{$event->registrations_count}} registrations</h3>
        <form method="GET" class="mb-4 container w-full max-w-lg mx-auto flex gap-2 justify-center">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search by name, email, number, or company"
                   class="input input-bordered w-full max-w-xs"/>

            <button type="submit" class="btn btn-primary">
                Search
            </button>
            <a href="{{ url()->current() }}" class="btn btn-ghost">
                Clear
            </a>
        </form>

        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <!-- head -->
                <thead>
                <tr>
                    <th>#</th>

                    <th>
                        <a href="{{ sort_link('first_name') }}" class="hover:underline flex items-center gap-1">
                            First Name
                            @if(request('sort') === 'first_name')
                                @if(request('direction') === 'asc')
                                    <x-akar-arrow-up class="w-4 h-4"/>
                                @else
                                    <x-akar-arrow-down class="w-4 h-4"/>
                                @endif
                            @endif
                        </a>
                    </th>

                    <th>
                        <a href="{{ sort_link('last_name') }}" class="hover:underline flex items-center gap-1">
                            Last Name
                            @if(request('sort') === 'last_name')
                                @if(request('direction') === 'asc')
                                    <x-akar-arrow-up class="w-4 h-4"/>
                                @else
                                    <x-akar-arrow-down class="w-4 h-4"/>
                                @endif
                            @endif
                        </a>
                    </th>

                    <th>
                        <a href="{{ sort_link('email') }}" class="hover:underline flex items-center gap-1">
                            Email
                            @if(request('sort') === 'email')
                                @if(request('direction') === 'asc')
                                    <x-akar-arrow-up class="w-4 h-4"/>
                                @else
                                    <x-akar-arrow-down class="w-4 h-4"/>
                                @endif
                            @endif
                        </a>
                    </th>

                    <th>
                        <a href="{{ sort_link('mobile_number') }}" class="hover:underline flex items-center gap-1">
                            Mobile Number
                            @if(request('sort') === 'mobile_number')
                                @if(request('direction') === 'asc')
                                    <x-akar-arrow-up class="w-4 h-4"/>
                                @else
                                    <x-akar-arrow-down class="w-4 h-4"/>
                                @endif
                            @endif
                        </a>
                    </th>

                    <th>
                        <a href="{{ sort_link('company') }}" class="hover:underline flex items-center gap-1">
                            Company
                            @if(request('sort') === 'company')
                                @if(request('direction') === 'asc')
                                    <x-akar-arrow-up class="w-4 h-4"/>
                                @else
                                    <x-akar-arrow-down class="w-4 h-4"/>
                                @endif
                            @endif
                        </a>
                    </th>

                    <th>
                        <a href="{{ sort_link('created_at') }}" class="hover:underline flex items-center gap-1">
                            Registered at
                            @if(request('sort') === 'created_at')
                                @if(request('direction') === 'asc')
                                    <x-akar-arrow-up class="w-4 h-4"/>
                                @else
                                    <x-akar-arrow-down class="w-4 h-4"/>
                                @endif
                            @endif
                        </a>
                    </th>
                </tr>
                </thead>

                <tbody>
                <!-- row 1 -->
                @forelse($registrations as $registration)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$registration->first_name}}</td>
                        <td>{{$registration->last_name}}</td>
                        <td>{{$registration->email}}</td>
                        <td>{{$registration->mobile_number}}</td>
                        <td>{{$registration->company}}</td>
                        <td data-time="true">{{$registration->created_at->toString()}}</td>
                    </tr>
                @empty
                    <td>No registrations found</td>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $registrations->links('pagination::default') }}
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.transformDataTime();
        });
    </script>
</x-auth-layout>

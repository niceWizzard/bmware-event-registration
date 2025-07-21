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
@endphp
<x-auth-layout>
    <section class="mx-auto container p-8 flex flex-col gap-2">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" class="text-lg font-medium"/>
        <h3 class="text-lg">Showing {{$event->registrations_count}} registrations</h3>
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <!-- head -->
                <thead>
                <tr>
                    <th></th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Company</th>
                    <th>Registered at</th>
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

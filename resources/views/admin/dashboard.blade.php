<x-auth-layout title="Dashboard">
    <a href="{{route('events.create')}}">Create</a>
    Admin
    <ul class="flex flex-col  gap-2 p-8">
        @foreach($events as $event)
            <li class="list-disc">
                <p>
                    {{$event->title}}
                </p>
                <p>
                    {{$event->slug}}
                </p>
            </li>
        @endforeach
    </ul>

</x-auth-layout>

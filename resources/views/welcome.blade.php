<x-card-layout>
    <form method="post" action="{{route('logout')}}">
        @csrf
        <button type="submit">Logout</button>
    </form>
    {{auth()->user()}}
</x-card-layout>

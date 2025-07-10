<x-header-layout title="">
    <x-slot:headerActions>
        @auth
            <a href="{{route('login')}}">
                Login
            </a>
        @endauth
        @guest
            <a href="/">
                Dashboard
            </a>
        @endguest
    </x-slot:headerActions>
    {{auth()->user()}}
</x-header-layout>

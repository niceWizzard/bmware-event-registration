<x-header-layout title="">
    <x-slot:headerActions>
        @auth
            <a href="/">
                Dashboard
            </a>
        @endauth
        @guest
            <a href="{{route('login')}}">
                Login
            </a>
        @endguest
    </x-slot:headerActions>
    <div class="p-8">
        <h3>Welcome</h3>
    </div>
</x-header-layout>

@php
    $breadcrumbs = [
        [
            'link' => route('events.index'),
            'text' => 'Home',
        ],
        [
            'text' => 'Profile',
        ],
    ];
@endphp
<x-auth-layout title="Profile">
    <section class="container mx-auto flex flex-col gap-4 p-8">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" class="text-lg font-medium" />
        <form action="{{route('profile.info')}}"
              method="POST"
              class="border border-base-200 rounded-md p-4 max-w-lg flex flex-col gap-2 w-full">
            @csrf
            <h3>Profile Information</h3>
            <x-form-input
                name="name"
                required
                :value="auth()->user()->name"
            />
            <button class="btn btn-primary">Update</button>
            @if(session('message.info'))
                <small>
                    {{session('message.info')}}
                </small>
            @endif
        </form>
        <form action="{{route('profile.email')}}"
              method="POST"
              class="border border-base-200 rounded-md p-4 max-w-lg flex flex-col gap-2 w-full">
            @csrf
            <h3>Email Information</h3>
            <x-form-input
                name="email"
                type="email"
                required
                :value="auth()->user()->email"
            />
            <x-form-input
                name="email_confirmation"
                required
                type="email"
            />
            <button class="btn btn-primary">Update</button>
            @if(session('message.email'))
                <small>
                    {{session('message.email')}}
                </small>
            @endif
        </form>
        <form action="{{route('profile.password')}}"
              method="POST"
              class="border border-base-200 rounded-md p-4 max-w-lg flex flex-col gap-2 w-full">
            @csrf
            <h3>Change Password</h3>
            <x-form-input
                name="current_password"
                type="password"
                required
            />
            <x-form-input
                name="password"
                type="password"
                required
            />
            <x-form-input
                name="password_confirmation"
                type="password"
                required
            />
            <button class="btn btn-primary">Update</button>
            @if(session('message.password'))
                <small>
                    {{session('message.password')}}
                </small>
            @endif
        </form>
        <form action="{{route('profile.delete')}}"
              method="POST"
              class="border border-base-200 rounded-md p-4 max-w-lg flex flex-col gap-2 w-full">
            @csrf
            <h3>Delete Account</h3>
            <x-form-input
                name="delete_password"
                type="password"
                label="Enter password"
                tip="Your account will be deleted!"
                required
            />
            <button class="btn btn-error">Delete</button>
        </form>
    </section>
</x-auth-layout>

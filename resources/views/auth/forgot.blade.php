<x-card-layout title="Forgot your Password?" card-title="Forgot your Password?">
    <form class="flex flex-col gap-2 items-end"
        method="POST"
        action="{{route('password.email')}}"
    >
        @csrf
        <x-form-input
            name="email"
            container-class="w-full"
        />

        <small>{{session('status')}}</small>
        <button class="btn btn-primary max-sm:w-full w-fit">Reset Password</button>
    </form>
</x-card-layout>

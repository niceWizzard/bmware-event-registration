<x-card-layout title="Reset your password" card-title="Reset your password">
    <form class="flex flex-col gap-2 items-end"
          method="POST"
          action="{{route('password.store')}}"
    >
        @csrf
        <input type="hidden" name="token" value="{{$token}}" />
        <x-form-input
            name="email"
            container-class="w-full"
            value="{{old('email', $email)}}"
        />
        <x-form-input
            name="password"
            container-class="w-full"
            type="password"
        />
        <x-form-input
            name="password_confirmation"
            container-class="w-full"
            type="password"
        />
        <small>{{session('status')}}</small>
        <button class="btn btn-primary max-sm:w-full w-fit">Send Reset Link</button>
    </form>
</x-card-layout>

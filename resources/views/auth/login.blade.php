<x-card-layout title="Login">
    <div class="flex flex-col gap-2 w-96 min-h-48 flex-wrap">
        <h2 class="text-2xl text-center font-bold mb-4 text-pretty ">
            Login
        </h2>
        <form
            class="flex flex-col justify-center gap-4"
            action="{{route('login')}}"
            method="POST"
        >
            @csrf
            <x-form-input
                name="email"
                type="email"
                class="rounded-none max-w-none "
                required
            />
            <x-form-input
                name="password"
                label="Password"
                type="password"
                class="rounded-none max-w-none"
                required
            />
            <button class="bg-primary text-on-primary px-3 py-2" type="submit">Login</button>
        </form>
    </div>
</x-card-layout>

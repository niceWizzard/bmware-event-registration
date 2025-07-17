<x-card-layout title="Login" card-title="Login" card-title-class="justify-center">
    <form
        x-data="{ loading: false }"
        @submit.prevent="loading = true; $el.submit()"
        class="flex flex-col justify-center gap-4"
        action="{{ route('login') }}"
        method="POST"
    >
        @csrf

        <x-form-input
            name="email"
            type="email"
            required
        >
            <x-slot:icon>
                <x-fas-user class="size-4"/>
            </x-slot:icon>
        </x-form-input>
        <x-form-input
            name="password"
            label="Password"
            type="password"
            required
        >
            <x-slot:icon>
                <x-fas-lock class="size-4"/>
            </x-slot:icon>
        </x-form-input>
        <button
            class="btn btn-primary"
            type="submit"
            :disabled="loading"
            x-text="loading ? 'Logging in…' : 'Login'"
        ></button>
    </form>
</x-card-layout>

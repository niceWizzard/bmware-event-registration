<x-card-layout title="Login">
    <h2 class="card-title justify-center">
        Login
    </h2>
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
        />
        <x-form-input
            name="password"
            label="Password"
            type="password"
            required
        />
        <button
            class="btn btn-primary"
            type="submit"
            :disabled="loading"
            x-text="loading ? 'Logging in…' : 'Login'"
        ></button>
    </form>
</x-card-layout>

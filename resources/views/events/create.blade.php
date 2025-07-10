<x-auth-layout title="Create Event">
    <section class="container mx-auto w-full p-8 flex flex-col items-center relative">
        <h2 class="text-lg font-bold">
            Create an Event
        </h2>
        <form
            x-data="{
                isLoading: false
            }"
            class="pt-4 flex flex-col gap-2"
            method="post"
            action="{{route('events.store')}}"
        >
            @csrf
            <x-form-input
                name="title"
            />
            <x-form-input
                name="partner"
            />
            <x-form-input
                name="venue"
            />
            <div class="flex gap-2">
                <x-form-input
                    name="start_date"
                    class="datetime-picker"
                />
                <x-form-input
                    name="end_date"
                    class="datetime-picker"
                />
            </div>
            <div class="flex gap-2">
                <x-form-input
                    name="registration_start_date"
                    class="datetime-picker"
                />
                <x-form-input
                    name="registration_end_date"
                    class="datetime-picker"
                />
            </div>
            <x-form-input
                name="description"
            />
            <button class="btn primary">
                Create
            </button>
        </form>
    </section>
    <script defer>
        document.addEventListener('DOMContentLoaded', (event) => {
            window.flatpickr(".datetime-picker", {
                enableTime: true,
            });
        })
    </script>
</x-auth-layout>

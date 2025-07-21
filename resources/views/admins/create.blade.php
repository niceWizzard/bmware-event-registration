@php
    use App\View\Components\Breadcrumb;

    $breadcrumbs = Breadcrumb::createAdminIndex([
        [
            'link' => route('admin.create'),
            'text' => "Create"
        ]
    ]);
@endphp
<x-auth-layout title="Create Admin">
    <section class="container mx-auto p-8">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" class="text-lg font-medium"/>
        <form class="max-w-lg mx-auto flex flex-col gap-2"
              action="{{route('admin.store')}}"
              x-data="{
                isLoading: false,
                haveCopied: false
              }"
              method="post"
              @submit.prevent="if(haveCopied) $el.submit()"
        >
            @csrf
            <h2 class="text-lg">Create Admin Account</h2>
            <x-form-input
                name="name"
            />
            <x-form-input
                name="email"
                type="email"
            />
            <x-form-input
                name="email_confirmation"
                type="email"
                label="Email Confirmation"
            />
            <x-form-input
                name="password"
                type="text"
                value="{{ $autoPassword }}"
                readonly
                label="Auto-Generated Password"
            />
            <div class="flex gap-2">
                <input type="checkbox" class="checkbox" x-model="haveCopied"/>
                <label>I have copied the password.</label>
            </div>
            <button class="btn btn-primary w-full"
                    x-text="isLoading ? 'Creating...' : 'Create'"
                    :disabled="isLoading || !haveCopied"
            >
                Create
            </button>
        </form>
    </section>
</x-auth-layout>

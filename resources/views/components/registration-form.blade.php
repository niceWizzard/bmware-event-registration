@props([
    'action' => ''
])
<form
    class="w-full mx-auto max-w-sm flex flex-col gap-2 "
    x-data="{
    isLoading: false
}"
    action="{{$action}}"
    @submit.prevent="isLoading = true; $el.submit()"
    method="POST"
>
    @csrf
    <div class="flex gap-2">
        <x-form-input
            name="first_name"
            label="First Name"
            required
        />
        <x-form-input
            name="last_name"
            label="Last Name"
            required
        />
    </div>
    <x-form-input
        name="email"
        label="Email"
        type="email"
        required
    />
    <x-form-input
        name="mobile_number"
        label="Mobile Number"
        required
    />
    <x-form-input
        name="gender"
        placeholder="Male"
        required
    />
    <x-form-input
        name="company"
        tip="Enter a company if you have one"
    />

    <button
        type="submit"
        class="btn btn-primary"
        :disabled="isLoading"
        x-text="isLoading ? 'Submitting...' : 'Submit'"
    >
        Submit
    </button>
</form>

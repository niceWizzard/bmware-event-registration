<form
    class="w-full mx-auto max-w-sm flex flex-col gap-2 "
    x-data="{
    isLoading: false
}"

    @submit.prevent="isLoading = true; console.log($el)"
>
    @csrf
    <div class="flex gap-2">
        <x-form-input
            name="first_name"
            label="First Name"
        />
        <x-form-input
            name="last_name"
            label="Last Name"
        />
    </div>
    <x-form-input
        name="email"
        label="Email"
        type="email"
    />
    <x-form-input
        name="mobile_number"
        label="Mobile Number"
    />
    <x-form-input
        name="gender"
        placeholder="Male"
    />
    <x-form-input
        name="company"
        tip="Enter a company if you have one"
    />

    <button
        type="submit"
        class="btn primary"
        :disabled="isLoading"
        x-text="isLoading ? 'Submitting...' : 'Submit'"
    >
        Submit
    </button>
</form>

@props([
    'action' => '',
    'method' => 'post',
    'class' => '',
    'event' => null,
    'specialMethod'=> null,
])

<script>
    function setDescriptionValue() {
        const input = document.querySelector('input[name="description"]');
        const html = window.quill.root.innerHTML;
        input.value = html === '<p><br></p>' ? '' : html;
    }
</script>

<form
    x-data="{ isLoading: false }"
    class="{{ twMerge(['pt-4 flex flex-col gap-2 w-full', $class]) }}"
    @submit.prevent="isLoading = true; setDescriptionValue(); $el.submit()"
    action="{{ $action }}"
    method="{{ $method }}"
>
    @csrf
    @if($specialMethod)
        @method($specialMethod)
    @endif
    @if(strtolower($method) !== 'post')
        @method($method)
    @endif

    <x-form-input
        name="title"
        value="{{ old('title', $event?->title) }}"
    >
        <x-slot:icon>
            <x-akar-edit class="size-4"/>
        </x-slot:icon>
    </x-form-input>

    <x-form-input
        name="short_name"
        tip="This will be shown in QR codes and the likes."
        value="{{ old('short_name', $event?->short_name) }}"
    >
        <x-slot:icon>
            <x-fas-tag class="size-4"/>
        </x-slot:icon>
    </x-form-input>

    <div class="flex gap-2 w-full max-sm:flex-col">
        <x-form-input
            name="partner"
            container-class="w-full"
            value="{{ old('partner', $event?->partner) }}"
        >
            <x-slot:icon>
                <x-akar-people-group class="size-4"/>
            </x-slot:icon>
        </x-form-input>
        <x-form-input
            name="venue"
            container-class="w-full"
            value="{{ old('venue', $event?->venue) }}"
        >
            <x-slot:icon>
                <x-akar-location class="size-4"/>
            </x-slot:icon>
        </x-form-input>
    </div>

    <div class="flex gap-2 w-full max-sm:flex-col">
        <x-form-input
            name="start_date"
            class="datetime-picker"
            container-class="w-full"
            value="{{ old('start_date', $event?->start_date) }}"
        >
            <x-slot:icon>
                <x-akar-calendar class="size-4"/>
            </x-slot:icon>
        </x-form-input>
        <x-form-input
            name="end_date"
            class="datetime-picker"
            container-class="w-full"
            value="{{ old('end_date', $event?->end_date) }}"
        >
            <x-slot:icon>
                <x-akar-calendar class="size-4"/>
            </x-slot:icon>
        </x-form-input>
    </div>
    <div class="flex gap-2 max-sm:flex-col">
        <x-form-input
            name="registration_start_date"
            class="datetime-picker"
            container-class="w-full"
            value="{{ old('registration_start_date', $event?->registration_start_date) }}"
        >
            <x-slot:icon>
                <x-akar-calendar class="size-4"/>
            </x-slot:icon>
        </x-form-input>
        <x-form-input
            name="registration_end_date"
            class="datetime-picker"
            container-class="w-full"
            value="{{ old('registration_end_date', $event?->registration_end_date) }}"
        >
            <x-slot:icon>
                <x-akar-calendar class="size-4"/>
            </x-slot:icon>
        </x-form-input>
    </div>
    <label for="description" class="text-lg font-medium">
        Body
    </label>
    <input type="hidden" id="description" name="description"/>
    <x-quill-editor>
        {!! old('description', $event?->description) !!}
    </x-quill-editor>

    <button class="btn btn-primary">
        {{ $event ? 'Update' : 'Create' }}
    </button>

    {{ $slot }}
</form>

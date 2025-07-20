@props([
    'action' => '',
    'method' => 'post',
    'class' => '',
    'event' => null,
    'specialMethod'=> null,
])

<script>
    function setDescriptionValue() {
        const input = document.querySelector('input[name="body"]');
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
    enctype="multipart/form-data"
>
    @csrf
    @if($specialMethod)
        @method($specialMethod)
    @endif
    @if(strtolower($method) !== 'post')
        @method($method)
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
        <x-form-input
            name="title"
            :value="old('title', $event?->title)"
            container-class="w-full "
        >
            <x-slot:icon>
                <x-akar-edit class="size-4"/>
            </x-slot:icon>
        </x-form-input>
        <x-form-input
            name="description"
            :value="old('description', $event?->title)"
            container-class="w-full "
            tip="What this event is about in short."
        />

        <x-form-input
            name="short_name"
            tip="This will be shown in QR codes and the likes."
            :value="old('short_name', $event?->short_name)"
            container-class="w-full "
        >
            <x-slot:icon>
                <x-fas-tag class="size-4"/>
            </x-slot:icon>
        </x-form-input>

        <x-form-input
            name="partner"
            container-class="w-full"
            :value="old('partner', $event?->partner)"
        >
            <x-slot:icon>
                <x-akar-people-group class="size-4"/>
            </x-slot:icon>
        </x-form-input>

        <x-form-input
            name="venue"
            container-class="w-full"
            :value="old('venue', $event?->venue)"
        >

            <x-slot:icon>
                <x-akar-location class="size-4"/>
            </x-slot:icon>
        </x-form-input>

    </div>

    <div class="grid grid-cols-1  md:grid-cols-2 lg:grid-cols-4 gap-2">
        <x-form-input
            name="start_date"
            class="datetime-picker"
            container-class="w-full"
            :value="old('start_date', $event?->start_date->toString())"
        >
            <x-slot:icon>
                <x-akar-calendar class="size-4"/>
            </x-slot:icon>
        </x-form-input>
        <x-form-input
            name="end_date"
            class="datetime-picker"
            container-class="w-full"
            :value="old('end_date', $event?->end_date->toString())"
        >
            <x-slot:icon>
                <x-akar-calendar class="size-4"/>
            </x-slot:icon>
        </x-form-input>
        <x-form-input
            name="registration_start_date"
            class="datetime-picker"
            container-class="w-full"
            :value="old('registration_start_date', $event?->registration_start_date->toString())"
        >
            <x-slot:icon>
                <x-akar-calendar class="size-4"/>
            </x-slot:icon>
        </x-form-input>
        <x-form-input
            name="registration_end_date"
            class="datetime-picker"
            container-class="w-full"
            :value="old('registration_end_date', $event?->registration_end_date->toString())"
        >
            <x-slot:icon>
                <x-akar-calendar class="size-4"/>
            </x-slot:icon>
        </x-form-input>
    </div>

    <div class="grid grid-cols-1  md:grid-cols-2 lg:grid-cols-4 gap-2">
        <x-file-input
            name="banner"
            label="Event Banner"
            :image-url="$event?->banner"
        />
        <x-file-input
            name="partner_picture"
            label="Partner Picture"
            :image-url="$event?->partner_picture"
        />
        <x-file-input
            name="venue_picture"
            label="Picture of Venue"
            :image-url="$event?->venue_picture"
        />
    </div>

    <label for="description" class="text-lg font-medium">
        Body
    </label>
    <input type="hidden" id="body" name="body"/>
    {{$event?->body}}
    <x-quill-editor>
        {!! old('body', $event?->body) !!}
    </x-quill-editor>

    <div class="flex max-sm:flex-col gap-2 justify-end">
        <a href="{{route('events.index')}}" class="btn btn-secondary max-sm:w-full w-fit ">
            Back
        </a>
        <button class="btn btn-primary max-sm:w-full w-fit ">
            {{ $event ? 'Update' : 'Create' }}
        </button>
    </div>
    {{ $slot }}
</form>

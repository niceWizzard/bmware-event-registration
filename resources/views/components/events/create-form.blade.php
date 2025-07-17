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
            name="short_name"
            tip="This will be shown in QR codes and the likes."
            :value="old('short_name', $event?->short_name)"
            container-class="w-full "
        >
            <x-slot:icon>
                <x-fas-tag class="size-4"/>
            </x-slot:icon>
        </x-form-input>
        @if ($event?->banner)
            <div class="col-span-2 flex flex-col gap-2"
                 x-data="{clearBanner: false}"
            >
                <h3 class="text-lg">Current Banner</h3>
                <img src="{{ asset('storage/' . $event->banner) }}"
                     alt="Current Banner"
                     class="object-contain"
                     x-show="!clearBanner"
                >
                <label>
                    <input name="clear_banner" type="checkbox" x-model="clearBanner" class="checkbox">
                    Clear Banner Instead.
                    <br>
                    <span x-show="clearBanner">Banner will be removed after submission.</span>
                    @if($errors->has('clear_banner'))
                        <p class="text-sm text-error">
                            {{$errors->first('clear_banner')}}
                        </p>
                    @endif
                </label>
            </div>
        @endif
        <div class="flex flex-col">
            <fieldset class="fieldset w-full">
                <legend class="fieldset-legend">Event Banner</legend>
                <input type="file" name="event_banner" class="file-input w-full"/>
                <label class="label">Max size 2MB</label>
                @if($errors->has('event_banner'))
                    <p class="text-sm text-error">
                        {{$errors->first('event_banner')}}
                    </p>
                @endif
            </fieldset>
        </div>
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
            :value="old('start_date', $event?->start_date)"
        >
            <x-slot:icon>
                <x-akar-calendar class="size-4"/>
            </x-slot:icon>
        </x-form-input>
        <x-form-input
            name="end_date"
            class="datetime-picker"
            container-class="w-full"
            :value="old('end_date', $event?->end_date)"
        >
            <x-slot:icon>
                <x-akar-calendar class="size-4"/>
            </x-slot:icon>
        </x-form-input>
        <x-form-input
            name="registration_start_date"
            class="datetime-picker"
            container-class="w-full"
            :value="old('registration_start_date', $event?->registration_start_date)"
        >
            <x-slot:icon>
                <x-akar-calendar class="size-4"/>
            </x-slot:icon>
        </x-form-input>
        <x-form-input
            name="registration_end_date"
            class="datetime-picker"
            container-class="w-full"
            :value="old('registration_end_date', $event?->registration_end_date)"
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

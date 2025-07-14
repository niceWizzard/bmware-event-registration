@props([
    'action' => '',
    'method' => 'post',
    'class' => '',
])

<script>
    function setDescriptionValue() {
        const input = document.querySelector('input[name="description"]');
        const html = window.quill.root.innerHTML;

        input.value = html === '<p><br></p>' ? '' : html;
    }
</script>

<form
    x-data="{
                isLoading: false,
            }"
    class="{{twMerge(['pt-4 flex flex-col gap-2 w-full', $class])}}"
    @submit.prevent="isLoading = true; setDescriptionValue(); $el.submit()"
    action="{{$action}}"
    method="{{$method}}"
>
    @csrf
    <x-form-input
        name="title"
    />
    <x-form-input
        name="short_name"
        tip="This will be shown in QR codes and the likes."
    />
    <div class="flex gap-2 w-full max-sm:flex-col">
        <x-form-input
            name="partner"
            container-class="w-full"
        />
        <x-form-input
            name="venue"
            container-class="w-full"
        />
    </div>
    <div class="flex gap-2 w-full max-sm:flex-col">
        <x-form-input
            name="start_date"
            class="datetime-picker"
            container-class="w-full"
        />
        <x-form-input
            name="end_date"
            class="datetime-picker"
            container-class="w-full"
        />
    </div>
    <div class="flex gap-2 max-sm:flex-col">
        <x-form-input
            name="registration_start_date"
            class="datetime-picker"
            container-class="w-full"
        />
        <x-form-input
            name="registration_end_date"
            class="datetime-picker"
            container-class="w-full"
        />
    </div>
    <input type="hidden" name="description"/>
    <x-quill-editor>
        {!! old('description') !!}
    </x-quill-editor>
    <button class="btn btn-primary">
        Create
    </button>
</form>

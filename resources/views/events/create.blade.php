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
            @submit.prevent="isLoading = true; setDescriptionValue(); $el.submit() "
            action="{{route('events.store')}}"
        >
            @csrf
            <x-form-input
                name="title"
            />
            <x-form-input
                name="short_name"
                tip="This will be shown in QR codes and the likes."
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
            <input type="hidden" name="description"/>
            <div id="editor" class="w-full min-h-48">
                {!! old('description') !!}
            </div>
            @if($errors->has('description'))
                <p class="text-error">
                    {{$errors->first('description')}}
                </p>
            @endif
            <button class="btn btn-primary">
                Create
            </button>
        </form>
    </section>
    <script defer>
        let quill;

        function setDescriptionValue() {
            const input = document.querySelector('input[name="description"]');
            const html = quill.root.innerHTML;

            input.value = html === '<p><br></p>' ? '' : html;
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            window.flatpickr(".datetime-picker", {
                enableTime: true,
            });
            quill = new Quill('#editor', {
                modules: {
                    toolbar: [
                        [{header: [1, 2, false]}],
                        ['bold', 'italic', 'underline'],
                        [{list: 'ordered'}, {list: 'bullet'}],
                        ['link']
                    ],
                    clipboard: {
                        matchers: [
                            ['img', () => {
                                return new Delta();
                            }] // Prevent pasted images
                        ]
                    }
                },
                placeholder: 'Type your text here...',
                theme: 'snow'
            });

            quill.root.addEventListener('drop', function (e) {
                e.preventDefault();
            });

            quill.root.addEventListener('paste', function (e) {
                // Optional: prevent all pasted images or files
                if (e.clipboardData && e.clipboardData.files.length > 0) {
                    e.preventDefault();
                }
            });
        })
    </script>
</x-auth-layout>

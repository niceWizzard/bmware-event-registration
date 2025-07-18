<script defer>
    let quill;

    document.addEventListener('DOMContentLoaded', (event) => {
        window.flatpickr(".datetime-picker", {
            enableTime: true,
            dateFormat: 'Z',
            altInput: true,
            altFormat: 'Y-m-d h:i K'
        });
        quill = new Quill('#editor', {
            modules: {
                toolbar: [
                    [{header: [1, 2, 3, 4, false]}],
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

        window.quill = quill;

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

<div id="editor" class="w-full min-h-48">
    {{$slot}}
</div>
@if($errors->has('description'))
    <p class="text-error">
        {{$errors->first('description')}}
    </p>
@endif

@props([
    'name',
    'placeholder' => 'Enter ' . ucfirst(str_replace('_', ' ', $name)),
    'label' => ucfirst(str_replace('_', ' ', $name)),
    'type' => 'text',
    'required' => false,
    'value' => old($name),
    'hidden' => false,
    'tip' => "",
    'containerClass'=> '',
])

@php
    $hasError = $errors->has($name);
@endphp

<fieldset class="@twMerge(['fieldset', $containerClass])">
    @unless($hidden)
        <legend class="
            @if($hasError)text-error @endif
            fieldset-legend
        "
        >
            {{ $label }}
            @if($required)
                <span class="text-secondary">*</span>
            @endif
        </legend>
    @endunless
    @if ($tip)
        <p class="label">{{ $tip }}</p>
    @endif
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        @if ($hidden) hidden @endif
        @if($required) required @endif
        {{ $attributes->twMerge([
            'input w-full',
            $hasError
                ? 'input-error' : ''
        ]) }}
    />

    @if ($hasError)
        <small class="text-sm pl-0.5 text-error">{{ $errors->first($name) }}</small>
    @endif
</fieldset>

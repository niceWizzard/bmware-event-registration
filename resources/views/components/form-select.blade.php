@props([
    'name',
    'placeholder' => 'Enter ' . ucfirst(str_replace('_', ' ', $name)),
    'label' => ucfirst(str_replace('_', ' ', $name)),
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
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        @if ($hidden) hidden @endif
        @if($required) required @endif
        {{ $attributes->twMerge([
            'select w-full',
            $hasError
                ? 'select-error' : ''
        ]) }}
    >
        {{$slot}}
    </select>

    @if ($hasError)
        <small class="text-sm pl-0.5 text-error">{{ $errors->first($name) }}</small>
    @endif
</fieldset>

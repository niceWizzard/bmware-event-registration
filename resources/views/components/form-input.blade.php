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
    'icon' => null,
])

@php
    $hasError = $errors->has($name);
@endphp

<fieldset class="{{twMerge(['fieldset', $containerClass])}}">
    @unless($hidden)
        <legend class="@if($hasError)text-error @endif fieldset-legend">
            {{ $label }}
            @if($required)
                <span class="text-secondary">*</span>
            @endif
        </legend>
    @endunless


    <label class="{{ twMerge('input w-full flex items-center gap-2', $hasError ? 'input-error' : '') }}">
        @if($icon)
            <span class="text-base-content/50">
                {{ $icon }}
            </span>
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
                'grow bg-transparent focus:outline-none',
            ]) }}
        />
    </label>
    @if ($tip)
        <p class="label text-sm">{{ $tip }}</p>
    @endif
    @if ($hasError)
        <small class="text-sm pl-0.5 text-error">{{ $errors->first($name) }}</small>
    @endif
</fieldset>


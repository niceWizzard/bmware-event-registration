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

<div class="@twMerge(['flex w-full max-w-sm flex-col gap-1 text-on-surface', $containerClass])">
    @unless($hidden)
        <label for="{{ $name }}" class="w-fit pl-0.5 text-sm">
            {{ $label }}
            @if($required)
                <span class="text-secondary">*</span>
            @endif
        </label>
    @endunless
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        @if ($hidden) hidden @endif
        @if($required) required @endif
        {!! $attributes->twMerge([
            'w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 transition-all',
            $hasError
                ? 'border-danger focus:border-danger focus:ring-1 focus:ring-danger' : ''
        ]) !!}
    />

    @if ($hasError)
        <small class="text-sm pl-0.5 text-danger">{{ $errors->first($name) }}</small>
    @endif

    @if ($tip)
        <p class="text-xs font-light text-on-surface/70">{{ $tip }}</p>
    @endif
</div>

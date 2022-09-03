@props([
    'options' => [],
    'selected' => null,
    'datepickerConfig' => [],
    'enableResetDatepicker' => true,
    'wrapperClass' => '',
    'labelText' => '',
    'labelClass' => 'absolute text-sm text-gray-800 top-0 z-10  px-1 left-3 text-xs font-medium bg-white',
    'class' => 'block px-3.5 pb-2.5 pt-2.5 w-full text-sm bg-transparent rounded-md border  focus:outline-none transition duration-150 ease-in-out ' . (isset($errors) && $errors->get($attributes->get('name')) ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red' : 'text-gray-500 border-gray-300 focus:border-gray-300'),
    'message',
    'prependIcon' => null,
    'appendIcon' => null,
])

<div class="{{ $wrapperClass }} relative pt-2">
    <div x-show="{{ strlen($prependIcon) }}">
        <div
            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pt-2 pl-3 text-sm text-gray-500">
            <i class="{{ $prependIcon }}"></i>
        </div>
    </div>

    <x-input
        {{ $attributes->whereStartsWith('x-') }}
        {{ $attributes->whereStartsWith('wire:') }}
        {{ $attributes->except(['labelText', 'labelClasses', 'wrapperClasses'])->merge(['class' => $class]) }}
        :options="$options"
        :selected="$selected"
        :datepicker-config="$datepickerConfig"
    ></x-input>
    <label
        for="{{ $attributes->get('name') }}"
        class="{{ $labelClass }}"
    >
        {{ $labelText }}
    </label>

    <div x-show="{{ strlen($appendIcon) }}">
        <div
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pt-2 pl-3 pr-4 text-sm text-gray-500">
            <i class="{{ $appendIcon }}"></i>
        </div>
    </div>

    @error($attributes->get('name'))
        <p class="mt-2 mb-0 text-xs text-red-600">
            {{ implode(', ', $errors->get($attributes->get('name'))) }}</p>
    @enderror
</div>

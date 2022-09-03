@props([
    'options' => [],
    'selected' => null,
    'datepickerConfig',
    'enableResetDatepicker' => true,
    'class' => 'block pb-2.5 pt-2.5 w-full text-sm text-gray-500 bg-transparent  border-b focus:outline-none ' . (isset($errors) && $errors->get($attributes->get('name')) ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red' : ''),
    'wrapperClass' => '',
    'message',
])
<div class="{{ $wrapperClass }}">
    <x-input
        {{ $attributes->whereStartsWith('wire:') }}
        {{ $attributes->merge([
            'class' => $class,
        ]) }}
        :options="$options"
        :selected="$selected"
    ></x-input>
    @error($attributes->get('name'))
        <p class="mt-2 mb-0 text-xs text-red-600">
            {{ implode(', ', $errors->get($attributes->get('name'))) }}</p>
    @enderror
</div>

@props(['label', 'open' => true, 'wrapperExtraClasses' => '', 'contentClasses' => 'bg-white px-8 py-8'])

<div
    class="shadow-black {{ $wrapperExtraClasses }} rounded-lg border border-gray-200 bg-white shadow-sm"
    x-data="{ open: {{ $open }} }"
    @if (isset($attributes['wire:key']))
        wire:key="{{ $attributes['wire:key'] }}"
    @endif
>
    <div
        class="flex cursor-pointer items-center border-b border-gray-200 bg-gray-50 px-8 py-4"
        @click="open = ! open"
    >
        <span
            class="block whitespace-nowrap text-xl font-semibold text-black-500"
        >
            {{ $label }}
        </span>
        <div class="ml-auto align-middle">
            <i
                class="text-md fa-solid fa-chevron-down"
                x-bind:class="!open ? 'rotate-180' : ''"
            ></i>
        </div>
    </div>
    <div
        x-show="open"
        x-cloak
        class="{{ $contentClasses }}"
    >
        {{ $slot }}
    </div>
</div>

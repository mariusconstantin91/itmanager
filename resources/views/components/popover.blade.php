<div
    x-cloak
    x-data="{ info: false }"
    @mouseleave="info = false"
    {{ $attributes->class(['relative', 'print:!hidden', 'flex', 'items-center', $attributes['margin-left']])->only('class') }}
>
    <div
        @mouseover="info = true"
        x-cloak
    >
        @switch($attributes['type'])
            @case('warning')
                <img src="{{ asset('img/popover/dark/warning_icon.svg') }}">
            @break

            @case('error')
                <img src="{{ asset('img/popover/dark/error_icon.svg') }}">
            @break

            @case('info')

                @default
                    <img src="{{ asset('img/popover/dark/info_icon.svg') }}">
            @endswitch
            <div
                x-show="info"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                @if ($attributes['arrange'] === 'right') class="absolute z-10 w-48 origin-top-right {{ $attributes['text-area'] ?? '-ml-4' }}"
            @else
                class="absolute z-10 w-48 origin-top-right {{ $attributes['text-area'] ?? '-ml-65' }}" @endif
            >
                <div
                    @if ($attributes['arrange'] === 'right') class="{{ $attributes['triangle'] ?? 'ml-5' }}"
                @else
                    class="{{ $attributes['triangle'] ?? 'ml-64' }}" @endif>
                    <svg
                        width="14"
                        height="14"
                        viewBox="0 0 14 14"
                    >
                        <image
                            xlink:href="{{ asset('img/popover/arrow_icon.svg') }}"
                        />
                    </svg>
                </div>
                <div
                    class="bg-black-popover opensans -mt-0.5 w-72 flex-shrink-0 rounded-lg px-5 py-3 text-xs text-white">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

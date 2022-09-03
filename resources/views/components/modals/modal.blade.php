@props([
    'id',
    'xshow',
    'title',
    'defaultActions' => [[
        'text' => 'Cancel',
        'classes' => 'link-secondary',
        'close_modal_onclick' => true,
    ]],
    'actions' => [],
    'showDefaultActions' => true,
    'showActions' => true,
    'size' => 'md',
])
@php
    $sizes = [
        'sm' => 'md:w-1/4',
        'md' => 'md:w-1/3',
        'lg' => 'md:w-1/2',
    ];
@endphp

<div
    x-cloak
>
    <div
        style="display: none"
        x-show="{{$xshow}}"
        class="fixed top-0 bottom-0 left-0 right-0 z-50 flex items-center justify-center overflow-auto bg-gray-900 bg-opacity-90"
        x-transition:enter="transition ease duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div
            style="display: none"
            x-show="{{$xshow}}"
            @click.away="{{$xshow}} = !{{$xshow}}"
            class="shadow-black w-1/4 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm {{ $sizes[$size] ?? $sizes['md'] }}"
            x-transition:enter="transition ease duration-100 transform"
            x-transition:enter-start="opacity-0 scale-90 translate-y-1"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease duration-100 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 translate-y-1"
        >
            <div
                class="flex flex-col cursor-pointer items-center border-b border-gray-200 bg-gray-50 px-8 py-4">
                @isset($title)
                    <h1 class="block whitespace-nowrap text-xl font-semibold text-black-500">{{ $title }}</h1>
                @endisset
            
                <div class="text-black-500 py-4">
                    {{ $slot }}
                </div>
                <div>
                    @if(count($actions = array_merge(($showDefaultActions ? $defaultActions : []) ?? [], $actions ?? [])))
                        <div class="flex cursor-pointer items-center border-b border-gray-200 bg-gray-50 px-8 py-4">
                            @foreach($actions as $action)
                                <button
                                    type="{{ $action['type'] ?? 'button' }}"
                                    @if(($action['close_modal_onclick'] ?? false) && isset($xshow))
                                        @click="{{ $xshow }} = !{{ $xshow }};"
                                    @endif
                                    class="{{ isset($action['button_classes']) ? $action['button_classes'] : (isset($action['color']) ? "text-{$action['color']}" : 'text-gray-500' ) . ' mr-4 rounded-lg border border-black-500 bg-transparent py-2 px-5 pb-2.5 text-sm font-medium text-black-500 hover:bg-gray-200'  }}"                            
                                    {!! collect($action['attributes'] ?? [])->map(function ($value, $attribute) {
                                        return "{$attribute}=\"{$value}\"";
                                    })->implode(' ') !!}
                                >
                                    {{ $action['text'] }}
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

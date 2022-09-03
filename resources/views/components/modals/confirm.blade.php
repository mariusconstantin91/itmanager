@props(['title', 'xshow', 'function', 'id', 'confirmBtnText', 'cancelBtnText', 'actions'])

<div x-cloak>
    <div
        x-show="{{ $xshow }}"
        class="fixed top-0 bottom-0 left-0 right-0 z-50 flex items-center justify-center overflow-auto bg-gray-900 bg-opacity-90"
        x-transition:enter="transition ease duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div
            x-show="{{ $xshow }}"
            @click.away="{{ $xshow }} = !{{ $xshow }}"
            class="shadow-black w-1/4 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm"
            x-transition:enter="transition ease duration-100 transform"
            x-transition:enter-start="opacity-0 scale-90 translate-y-1"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease duration-100 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 translate-y-1"
        >
            <div
                class="flex cursor-pointer items-center border-b border-gray-200 bg-gray-50 px-8 py-4">
                <span
                    class="block whitespace-nowrap text-xl font-semibold text-black-500"
                >
                    {{ $title }}
                </span>
                <div
                    class="ml-auto cursor-pointer align-middle text-xl font-semibold text-black-500"
                    @click="{{ $xshow }} = !{{ $xshow }};"
                >
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>
            <div class="px-8 py-4">
                <p class="mt-2 mb-6 text-base font-normal text-gray-600">
                    {{ $slot }}</p>

                <div class="mt-9 flex justify-end">
                    <button
                        type="button"
                        @click="{{ $xshow }} = !{{ $xshow }};"
                        class="mr-4 rounded-lg border border-black-500 bg-transparent py-2 px-5 pb-2.5 text-sm font-medium text-black-500 hover:bg-gray-200"
                    >
                        {{ $cancelBtnText ?? 'Cancel' }}
                    </button>

                    @isset($actions)
                        @foreach ($actions as $action)
                            <button
                                type="button"
                                @click="{{ $xshow }} = !{{ $xshow }};"
                                wire:click="{{ $action['function'] . (isset($action['parameters']) ? '(' . implode(', ', $action['parameters']) . ')' : '') }}"
                                class="{{ isset($action['color']) ? "text-{$action['color']}" : 'text-gray-500' }} mr-4 rounded-lg border border-black-500 bg-transparent py-2 px-5 pb-2.5 text-sm font-medium text-black-500 hover:bg-gray-200"
                            >
                                {{ $action['text'] }}
                            </button>
                        @endforeach
                    @endisset

                    <button
                        type="button"
                        wire:click='{{ $function }}({{ $id }})'
                        @click="{{ $xshow }} = !{{ $xshow }};"
                        class="rounded-lg bg-gray-900 py-2 px-5 pb-2.5 text-sm font-medium text-white hover:bg-green-700"
                    >
                        {{ $confirmBtnText ?? 'Yes' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

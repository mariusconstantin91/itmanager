@props(['options', 'selected', 'datepickerConfig', 'enableResetDatepicker' => true, 'attributeName' => 'name', 'key' => 'id', 'optionsProperty' => '', 'label' => '', 'icon' => ''])

@switch($attributes->get('type'))
    @case('select')
        <select
            {{ $attributes->whereStartsWith('x-') }}
            {{ $attributes->whereStartsWith('wire:') }}
            {{ $attributes->only(['class', 'name', 'id'])->merge([
                'class' => 'form-input form-select',
            ]) }}
        >
            @isset($selected)
                <option
                    selected
                    hidden
                    value=""
                >{{ $selected }}</option>
            @endisset
            @isset($options)
                @foreach ($options as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            @endisset
        </select>
    @break

    @case('select-choice')
        <div
            x-data
            wire:ignore
            x-init="() => {
                var choices = new Choices($refs.{{ str_replace('.', '', $attributes['name']) }}, {
                    itemSelectText: '',
                    'searchEnabled': false
                });
                choices.passedElement.element.addEventListener(
                    'change',
                    function(event) {
                        values = event.detail.value;
                        @this.set('{!! $attributes['name'] !!}', values);
                    },
                    false,
                );
                let selected = parseInt($wire.get('{!! $attributes['name'] !!}')).toString();
                choices.setChoiceByValue(selected);
            }"
        >
            <select
                id="{{ $attributes['name'] }}"
                wire-model="{{ $attributes['wire:model.lazy'] }}"
                {{ $attributes->whereStartsWith('x-') }}
                {{ $attributes->whereStartsWith('wire:') }}
                {{ $attributes->except(['options', 'selected'])->merge([
                    'class' => 'form-input form-select',
                ]) }}
                x-ref="{{ str_replace('.', '', $attributes['name']) }}"
            >
                <option value="">{{ isset($selected) ? $selected : 'All' }}
                </option>
                @if (count($options) > 0)
                    @foreach ($options as $key => $option)
                        <option value="{{ $key }}">{{ $option }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    @break

    @case('select-choice-multiple')
        <div
            x-data
            wire:ignore
            x-init="() => {
                var choices = Choices($refs.{{ $attributes['name'] }}, {
                    itemSelectText: '',
                    removeItems: true,
                    removeItemButton: true,
                });
                choices.passedElement.element.addEventListener(
                    'change',
                    function(event) {
                        values = getSelectValues($refs.{{ $attributes['name'] }});
                        @this.set('{{ $attributes['wire:model'] }}', values);
                    },
                    false
                );
                items = '{!! $attributes['selected'] !!}';
                if (Array.isArray(items)) {
                    items.forEach(function(select) {
                        choices.setChoiceByValue((select).toString());
                    });
                }
            
                function getSelectValues(select) {
                    var result = [];
                    var options = select && select.options;
                    var opt;
                    for (var i = 0, iLen = options.length; i < iLen; i++) {
                        opt = options[i];
                        if (opt.selected) {
                            result.push(opt.value || opt.text);
                        }
                    }
                    return result;
                }
            }"
        >
            <select
                id="{{ $attributes['name'] }}"
                {{ $attributes->whereStartsWith('x-') }}
                {{ $attributes->whereStartsWith('wire:') }}
                x-ref="{{ $attributes['name'] }}"
                multiple="multiple"
            >
                @if (count($options) > 0)
                    @foreach ($options as $key => $option)
                        <option value="{{ $key }}">{{ $option }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    @break

    @case('search-dropdown')
        <div
            class="relative flex items-center"
            x-data="{ showOptions: false }"
            @click.outside="showOptions=false"
            x-init="$wire.initSearchDropdown('{{ $attributes['name'] }}', '{{ $attributes['initialText'] }}')"
        >
            @php
                $inputName = str_replace('.', ' ', $attributes->get('name'));
                $inputName = str_replace('_', ' ', $inputName);
                $inputName = ucwords($inputName);
                $inputName = str_replace(' ', '', $inputName);
                $inputName = lcfirst($inputName . 'Input');
            @endphp
            <input
                type="text"
                class="form-input {{ $attributes->get('class') }}"
                placeholder="{{ $attributes->get('placeholder') }}"
                wire:keydown.enter.prevent="selectItem('{{ $attributes->get('name') }}', 0)"
                wire:model="{{ $inputName }}"
                wire:click="showClick('{{ $attributes->get('name') }}')"
                {{ $attributes->except(['class', 'placeholder', 'type', 'name', 'wire:model.lazy', 'wire:model']) }}
                @click="showOptions=true"
            />
            <i class="fa-solid fa-chevron-down absolute right-2 top-3.5 text-sm"></i>
            <div
                x-show="showOptions"
                x-cloak
                class="absolute top-full z-20 w-full"
            >
                <div
                    wire:loading
                    class="absolute top-full z-20 w-full overflow-hidden rounded-lg rounded-t-none border border-t-0 border-gray-300 bg-white shadow-lg"
                >
                    <div
                        class="block border-t border-gray-300 p-3 text-sm text-gray-500">
                        Searching...</div>
                </div>
                <ul
                    class="absolute top-full z-20 w-full overflow-hidden rounded-lg rounded-t-none border border-t-0 border-gray-300 bg-white shadow-lg">
                    @if (!empty($this->items[$attributes->get('name')]))
                        @foreach ($this->items[$attributes->get('name')] as $i => $item)
                            <li
                                wire:click.prevent="selectItem('{{ $attributes->get('name') }}', '{{ $i }}')"
                                @click="showOptions=false"
                                class="block cursor-pointer border-t border-gray-300 py-1.5 px-3 text-sm font-medium text-gray-500 hover:bg-green-50 hover:text-green-700"
                            >{{ $item }}</li>
                        @endforeach
                    @else
                        <div
                            wire:loading.remove
                            class="block border-t border-gray-300 p-3 text-sm font-medium text-gray-500"
                        >
                            No results!</div>
                    @endif
                </ul>
            </div>
        </div>
    @break

    @case('search-dropdown-extended')
        <div
            class="relative flex items-center"
            x-data="{ showOptions: false }"
            @click.outside="showOptions=false"
            x-init="$wire.initSearchDropdown('{{ $attributes['name'] }}', '{{ $attributes['initialText'] }}')"
        >
            <input
                type="text"
                class="form-input {{ $attributes->get('class') }}"
                placeholder="{{ $attributes->get('placeholder') }}"
                wire:keydown.enter.prevent="selectItem('{{ $attributes->get('name') }}', 0)"
                wire:keyup="{{ $attributes->get('functionOptions') }}('{{ $attributes->get('name') }}', document.getElementById('{{ $attributes->get('name') }}').value)"
                wire:model="inputNames.{{ str_replace('.', '_', $attributes->get('name')) }}"
                wire:click="showClick('{{ $attributes->get('name') }}', '{{ $attributes->get('functionOptions') }}')"
                {{ $attributes->except(['class', 'placeholder', 'type', 'name', 'wire:model.lazy', 'wire:model']) }}
                @click="showOptions=true"
            />
            <i class="fa-solid fa-chevron-down absolute right-2 top-3.5 text-sm"></i>
            <div
                x-show="showOptions"
                x-cloak
                class="absolute top-full z-20 w-full"
            >
                <div
                    wire:loading
                    class="absolute top-full z-20 w-full overflow-hidden rounded-lg rounded-t-none border border-t-0 border-gray-300 bg-white shadow-lg"
                >
                    <div
                        class="block border-t border-gray-300 p-3 text-sm text-gray-500">
                        Searching...</div>
                </div>
                <ul
                    class="absolute top-full z-20 w-full overflow-hidden rounded-lg rounded-t-none border border-t-0 border-gray-300 bg-white shadow-lg">
                    @if (!empty($this->items[$attributes->get('name')]))
                        @foreach ($this->items[$attributes->get('name')] as $i => $item)
                            <li
                                wire:click.prevent="selectItem('{{ $attributes->get('name') }}', '{{ $i }}')"
                                @click="showOptions=false"
                                class="block cursor-pointer border-t border-gray-300 py-1.5 px-3 text-sm font-medium text-gray-500 hover:bg-green-50 hover:text-green-700"
                            >{{ $item }}</li>
                        @endforeach
                    @else
                        <div
                            wire:loading.remove
                            class="block border-t border-gray-300 p-3 text-sm font-medium text-gray-500"
                        >
                            No results!</div>
                    @endif
                </ul>
            </div>
        </div>
    @break

    @case('select-formated')
        <div
            x-data="{ showOptions: false }"
            @click.outside="showOptions=false"
            class="relative flex items-center"
            x-init="$wire.initSelect('{{ $attributes['name'] }}', '{{ $optionsProperty }}')"
        >
            <select
                class="hidden"
                wire:model="{{ $attributes->get('name') }}"
            >
                @if (!empty($options))
                    @foreach ($options as $i => $item)
                        <option value="{{ $i }}"> {{ $item }}
                        </option>
                    @endforeach
                @endif
            </select>
            <div
                class="form-input select-simple {{ $attributes['class'] }} cursor-pointer"
                @click="showOptions=true"
            >
                @if (isset($this->choosenOptionSelect[str_replace('.', '_', $attributes['name'])]))
                    {{ $this->choosenOptionSelect[str_replace('.', '_', $attributes['name'])] }}
                @else
                    {{ $attributes['placeholder'] }}
                @endif
                <i
                    class="fa-solid fa-chevron-down absolute right-2 top-3.5 text-sm"></i>
            </div>
            <div
                x-show="showOptions"
                x-cloak
                class="absolute top-full z-20 w-full"
            >
                <ul
                    class="absolute top-full z-20 w-full overflow-hidden rounded-lg rounded-t-none border border-t-0 border-gray-300 bg-white shadow-lg">
                    @if (!empty($options))
                        @foreach ($options as $i => $item)
                            <li
                                wire:click.prevent="selectItemSelect('{{ $attributes->get('name') }}', '{{ $i }}', '{{ $item }}')"
                                @click="showOptions=false"
                                class="block cursor-pointer border-t border-gray-300 py-1.5 px-3 text-sm font-medium text-gray-500 hover:bg-green-50 hover:text-green-700"
                            >{{ $item }}</li>
                        @endforeach
                    @else
                        <div
                            wire:loading.remove
                            class="block border-t border-gray-300 p-3 text-sm font-medium text-gray-500"
                        >
                            No options!</div>
                    @endif
                </ul>
            </div>
        </div>
    @break

    @case('select-formated-multi')
        <div
            class="relative flex items-center"
            x-data="{ showOptions: false }"
            @click.outside="showOptions=false"
            x-init="$wire.initSelectMulti('{{ $attributes['name'] }}', '{{ $optionsProperty }}')"
        >
            <div
                class="{{ $attributes['class'] }} flex cursor-pointer"
                @click="showOptions=true"
            >
                @foreach ($this->choosenOptionSelectMulti[$attributes['name']] as $index => $choosenItem)
                    <div
                        class="mr-2 flex items-center justify-center rounded-md border border-gray-300 bg-gray-100 px-1 py-1 pt-0 text-sm font-normal text-gray-500">
                        <div
                            class="max-w-full flex-initial text-sm font-normal leading-none">
                            {{ $choosenItem }}</div>
                        <div
                            class="flex flex-auto flex-row-reverse pt-1 pl-1 text-xs font-normal"
                            wire:click.stop="removeItemSelectMulti('{{ $attributes['name'] }}', {{ $index }})"
                        >
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </div>
                @endforeach
                <div class="flex-1">
                    <input
                        placeholder=""
                        wire:model="{{ $attributes->get('input') }}"
                        class="h-full w-full appearance-none bg-transparent text-gray-500 outline-none"
                    >
                </div>
                <i
                    class="fa-solid fa-chevron-down absolute right-2 top-3.5 text-sm"></i>
            </div>
            <div
                x-show="showOptions"
                x-cloak
                class="absolute top-full z-20 w-full"
            >
                <ul
                    class="absolute top-full z-20 w-full overflow-hidden rounded-lg rounded-t-none border border-t-0 border-gray-300 bg-white shadow-lg">
                    @if (!empty($options))
                        @foreach ($options as $i => $item)
                            <li
                                wire:click.prevent="selectItemSelectMulti('{{ $attributes->get('name') }}', '{{ $i }}', '{{ $item }}', '{{ $attributes->get('input') }}')"
                                class="block cursor-pointer border-t border-gray-300 py-1.5 px-3 text-sm font-medium text-gray-500 hover:bg-green-50 hover:text-green-700"
                                @click="showOptions=false"
                            >{{ $item }}</li>
                        @endforeach
                    @else
                        <div
                            wire:loading.remove
                            class="block border-t border-gray-300 p-3 text-sm font-medium text-gray-500"
                        >
                            No options!</div>
                    @endif
                </ul>
            </div>
        </div>
    @break

    @case('toggle')
        <div
            x-data="{ toggle: $wire.{{ $attributes->get('model') }} }"
            class="flex items-center"
        >
            <span
                {{ $attributes->only('class')->merge([
                    'class' => 'text-sm font-semibold poppins text-black-soft',
                ]) }}
            >
                {{ $attributes->get('text') }}
            </span>
            <div class="mx-2 flex items-center justify-center">
                <div
                    class="relative h-4 w-7 rounded-full transition duration-200 ease-linear md:h-5 md:w-8"
                    :class="[toggle == '1' ?
                        '{{ $attributes->get('color') == 'blue' ? 'bg-primary' : 'bg-black-soft' }} bg-opacity-90' :
                        ''
                    ]"
                >
                    <label
                        for="{{ $attributes->get('id') }}"
                        class="{{ $attributes->get('color') == 'blue' ? 'border-primary bg-blue-sky-darker' : 'border-black-soft bg-white' }} absolute left-0 mb-2 h-4 w-4 transform cursor-pointer rounded-full border-2 border-opacity-90 transition duration-100 ease-linear md:h-5 md:w-5 md:border-4"
                        :class="[toggle == '1' ? 'translate-x-3' : 'translate-x-0']"
                    ></label>
                    <input
                        wire:model={{ $attributes->get('model') }}
                        type="checkbox"
                        id="{{ $attributes->get('id') }}"
                        name="toggle"
                        class="{{ $attributes->get('color') == 'blue' ? 'border-primary' : 'border-black-soft' }} mb-2 h-full w-full appearance-none rounded-2xl border-2 border-opacity-90 focus:outline-none active:outline-none md:mb-0 md:border-4"
                        @click="toggle == '0' ? toggle = '1' : toggle = '0'"
                    >
                </div>
            </div>
        </div>
    @break

    @case('switch')
        <div
            x-data="{ toggle: $wire.{{ $attributes->whereStartsWith('wire:model')->first() }} }"
            class="flex items-center"
        >
            <label
                for="{{ $attributes->get('id') }}"
                class="relative inline-flex cursor-pointer items-center"
            >
                <input
                    wire:model="{{ $attributes->whereStartsWith('wire:model')->first() }}"
                    type="checkbox"
                    @click="toggle = !toggle;"
                    data-value="{{ $attributes->get('value') }}"
                    id="{{ $attributes->get('id') }}"
                    class="peer sr-only"
                >
                <div
                    class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:top-[2px] after:left-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-green-700 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:peer-focus:ring-blue-800">
                </div>
                <span
                    class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $label }}</span>
            </label>

        </div>
    @break

    @case('datepicker')
        @php
        $datepickerID = uniqid('datepicker_widget_');
        $datepickerConfig = array_merge(
            [
                'wrap' => true,
                'dateFormat' => 'm/d/Y',
                'defaultDate' => '',
            ],
            $datepickerConfig ?? [],
        );
        @endphp

        <div
            x-data
            x-ref="{{ $datepickerID }}"
            x-init="flatpickr($el, {{ json_encode($datepickerConfig) }});"
            id="{{ $datepickerID }}"
            class="flatpickr form-input form-datepicker container relative mx-auto flex items-center justify-center sm:col-span-6"
        >
            <input
                
                type="text"
                data-input
                autocomplete="off"
                {{ $attributes->class(['w-full', 'outline-0']) }}
                {{ $attributes->whereStartsWith('x-') }}
                {{ $attributes->whereStartsWith('wire:') }}
            >
            @if ($icon)
                <i class="{{ $icon }} absolute right-2 top-3.5 text-sm"></i>
            @endif
        </div>
    @break

    @case('timepicker')
        @php
        $datepickerID = uniqid('datepicker_widget_');
        $datepickerConfig = array_merge(
            [
                'wrap' => true,
                'enableTime' => true,
                'noCalendar' => true,
                'time_24hr' => true,
                'dateFormat' => 'H:i',
            ],
            $datepickerConfig ?? [],
        );
        @endphp
        <div
            wire:ignore
            x-data
            x-ref="{{ $datepickerID }}"
            x-init="flatpickr($refs.{{ $datepickerID }}, {{ json_encode($datepickerConfig) }});"
            class="flatpickr form-input form-datepicker container relative col-span-6 mx-auto flex items-center justify-center sm:col-span-6"
        >
            <input
                id="{{ $datepickerID }}"
                type="text"
                data-input
                autocomplete="off"
                {{ $attributes->merge([
                    'class' => 'w-full outline-0 pr-9',
                ]) }}
            >

            @if ($icon)
                <i class="{{ $icon }} absolute right-2 top-3.5 text-sm"></i>
            @endif

            @if ($enableResetDatepicker)
                <a
                    data-clear
                    class="input-button absolute top-0 bottom-0 right-4 flex cursor-pointer items-center justify-center"
                    title="clear"
                >
                    <i class="las la-times"></i>
                </a>
            @endif
        </div>
    @break

    @case('number')
        <div class="relative">
            <input
                @if (!$attributes->get('x-mask')) x-mask="{
                        numeral: true,
                        numeralThousandsGroupStyle: 'none',
                    }" @endif
                {{ $attributes->whereStartsWith('x-') }}
                {{ $attributes->whereStartsWith('wire:') }}
                {{ $attributes->only([
                        'class',
                        'placeholder',
                        'id',
                        'style',
                        'min',
                        'max',
                        'value',
                        'x-mask',
                    ])->merge([
                        'type' => 'text',
                        'class' => 'form-input ',
                        'inputmode' => 'numeric',
                    ]) }}
            >
        </div>
    @break

    @case('number-buttons')
        <div class="relative">
            <input
                @if (!$attributes->get('x-mask')) x-mask="{
                    numeral: true,
                    numeralThousandsGroupStyle: 'none'
                    }" @endif
                {{ $attributes->whereStartsWith('x-') }}
                {{ $attributes->whereStartsWith('wire:') }}
                {{ $attributes->only([
                        'class',
                        'placeholder',
                        'type',
                        'id',
                        'style',
                        'min',
                        'max',
                        'value',
                        'x-mask',
                    ])->merge([
                        'type' => 'text',
                        'class' => 'form-input ',
                        'inputmode' => 'numeric',
                    ]) }}
            >
            <a
                class="absolute top-0 right-3.5 mt-1.5 mr-8 flex cursor-pointer items-center justify-center bg-gray-100 p-2 text-sm text-gray-500"
                title="minus"
                wire:click.prevent="decrease('{{ $attributes['wire:model'] }}{{ $attributes['wire:model.lazy'] }}')"
            >
                <i class="fa-solid fa-minus"></i>
            </a>
            <a
                class="absolute top-0 right-2 mt-1.5 flex cursor-pointer items-center justify-center bg-gray-100 p-2 text-sm text-gray-500"
                title="add"
                wire:click.prevent="increase('{{ $attributes['wire:model'] }}{{ $attributes['wire:model.lazy'] }}')"
            >
                <i class="fa-solid fa-plus"></i>
            </a>
        </div>
    @break

    @case('email')
        <input
            {{ $attributes->whereStartsWith('x-') }}
            {{ $attributes->whereStartsWith('wire:') }}
            {{ $attributes->only([
                    'class',
                    'placeholder',
                    'required',
                    'type',
                    'id',
                    'style',
                    'min',
                    'max',
                    'value',
                ])->merge([
                    'type' => 'email',
                    'class' => '',
                ]) }}
        >
    @break

    @case('date')
        <input
            {{ $attributes->whereStartsWith('x-') }}
            {{ $attributes->whereStartsWith('wire:') }}
            {{ $attributes->only([
                    'class',
                    'placeholder',
                    'type',
                    'id',
                    'style',
                    'min',
                    'max',
                    'value',
                ])->merge([
                    'type' => 'date',
                    'class' => 'form-input',
                ]) }}
        >
    @break

    @case('time')
        <input
            {{ $attributes->whereStartsWith('x-') }}
            {{ $attributes->whereStartsWith('wire:') }}
            {{ $attributes->only([
                    'class',
                    'placeholder',
                    'type',
                    'id',
                    'style',
                    'min',
                    'max',
                    'value',
                ])->merge([
                    'type' => 'date',
                    'class' => 'form-input',
                ]) }}
        >
    @break

    @case('right-tooltip')
        <div class="form-input flex items-center">
            <input
                {{ $attributes->whereStartsWith('x-') }}
                {{ $attributes->whereStartsWith('wire:') }}
                {{ $attributes->only(['class', 'placeholder', 'id', 'style', 'min', 'max', 'value'])->merge([
                        'type' => 'number',
                        'min' => 0,
                        'class' => 'w-full outline-0',
                    ]) }}
            >
            <span
                class="text-gray-tooltip w-max whitespace-nowrap px-2 text-sm">{{ $attributes->get('tooltip') }}</span>
        </div>
    @break

    @case('text-with-style')
        <input
            {{ $attributes->whereStartsWith('x-') }}
            {{ $attributes->whereStartsWith('wire:') }}
            {{ $attributes->only([
                    'class',
                    'placeholder',
                    'type',
                    'id',
                    'style',
                    'min',
                    'max',
                    'value',
                ])->merge([
                    'type' => 'text',
                    'class' => 'form-input input-styles',
                ]) }}
        >
    @break;
    @case('textarea')
        <textarea
            {{ $attributes->whereStartsWith('wire:') }}
            {{ $attributes->only([
                    'class',
                    'placeholder',
                    'type',
                    'id',
                    'style',
                    'value',
                    'rows'
                ])->merge([
                    'class' => 'form-input',
                ]) }}
        > </textarea>
        @break;
    @case('password')
        <input
            {{ $attributes->whereStartsWith('x-') }}
            {{ $attributes->whereStartsWith('wire:') }}
            {{ $attributes->only([
                    'class',
                    'placeholder',
                    'type',
                    'id',
                    'style',
                    'min',
                    'max',
                    'value',
                    'disabled',
                    'readonly',
                ])->merge([
                    'type' => 'password',
                    'class' => 'form-input',
                ]) }}
            >
        @break;
    @case('file')
        <input
            {{ $attributes->whereStartsWith('x-') }}
            {{ $attributes->whereStartsWith('wire:') }}
            {{ $attributes->only([
                    'class',
                    'placeholder',
                    'type',
                    'id',
                    'style',
                    'min',
                    'max',
                    'value',
                    'disabled',
                    'readonly',
                ])->merge([
                    'type' => 'file',
                    'class' => 'form-input',
                ]) }}
            >
        @break;
    @default
        <input
            {{ $attributes->whereStartsWith('x-') }}
            {{ $attributes->whereStartsWith('wire:') }}
            {{ $attributes->only([
                    'class',
                    'placeholder',
                    'type',
                    'id',
                    'style',
                    'min',
                    'max',
                    'value',
                    'disabled',
                    'readonly',
                ])->merge([
                    'type' => 'text',
                    'class' => 'form-input',
                ]) }}
        >
    @break;
@endswitch

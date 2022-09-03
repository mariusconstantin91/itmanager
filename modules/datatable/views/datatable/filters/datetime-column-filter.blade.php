<div
    class="filter-width"
    wire:ignore
>
    <x-input-group
        id="datepicker-{{ $filter->name }}"
        placeholder="{{ $filter->placeholder }}"
        labelText="{{ $filter->label }}"
        :type="'datepicker'"
        :datepicker-config="[
            'mode' => $filter->range ? 'range' : 'single',
            'dateFormat' => $filter->format,
            'enableTime' => in_array($filter->type, ['time', 'datetime']),
            'noCalendar' => in_array($filter->type, ['time']),
        ]"
        wire:model.debounce.500ms="filters.{{ $filter->name }}"
    />
</div>

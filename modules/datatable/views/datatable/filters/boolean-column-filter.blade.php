<div class="flex items-center">
    <x-input
        id="datatable.filters.{{ $filter->name }}"
        type="switch"
        wire:model.debounce.500ms="filters.{{ $filter->name }}"
        label="{{ $filter->placeholder }}"
    />
</div>

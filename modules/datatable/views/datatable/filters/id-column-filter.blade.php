<div class="col-span-4">
    @if (isset($filter->label))
        <label
            for="datatable.filters.{{ $filter->name }}"
            class="mb-2 block"
        >{{ $filter->label }}</label>
    @endif
    <x-input
        id="datatable.filters.{{ $filter->name }}"
        wire:model.debounce.500ms="filters.{{ $filter->name }}"
        type="number"
        placeholder="{{ $filter->placeholder }}"
    />
</div>

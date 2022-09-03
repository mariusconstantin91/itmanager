<div class="filter-width">
    <x-input-group
        id="datatable.filters.{{ $filter->name }}"
        wire:model.debounce.500ms="filters.{{ $filter->name }}"
        type="select-choice"
        placeholder="Search by {{ $filter->placeholder }}"
        labelText="{{ $filter->label }}"
        append-icon="{{ $filter->icon }}"
        :options="$filter->options"
    />
</div>

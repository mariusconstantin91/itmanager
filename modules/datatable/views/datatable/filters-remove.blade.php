<div>
    @if ($datatable->showResetFiltersButton())
        <button
            class="link-info uppercase"
            wire:click="removeFilters"
        >x Remove
            Filters</button>
    @endif
</div>

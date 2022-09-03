<div wire:key="{{ $datatableId }}_datatable_search">
    @if ($datatable->isSearchable())
        <div class="w-80">
            <x-input-group
                placeholder='Search'
                wire:model.debounce.500ms="search"
                class="search-input input-styles"
                wrapperClass="pt-0"
                prepend-icon="fa-solid fa-magnifying-glass"
            > </x-input-group>
        </div>
    @endif
</div>

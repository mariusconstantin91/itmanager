<div wire:key="{{ $datatableId }}_datatable_filters">
    @if ($datatable->isFilterable())
        <div class="filters-wrapper">
            <p
                class="flex cursor-pointer justify-end text-sm font-semibold text-green-700"
                wire:click="removeFilters"
            >
                Reset Filters
            </p>
            <div class="filters flex-wrap">
                @foreach ($datatable->filters() as $key => $filter)
                    {!! $filter->render() !!}
                @endforeach
            </div>
        </div>
    @endif
</div>

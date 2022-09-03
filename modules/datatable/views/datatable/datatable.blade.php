<div
    x-cloak
    wire:id="{{ $datatableId }}"
    class="table-layout"
    x-data="{
        showErrorAlert: true,
    }"
>
    <x-alerts.error/>
    {{-- DataTable --}}
    <table class="table">
        <thead class="table-head">
            <tr class="table-head-row">
                @foreach ($datatable->columns()->where('visibility', true) as $key => $column)
                    <td
                        class="table-head-cell"
                        wire:key="{{ "datatable-column-$datatableId-#$key" }}"
                    >
                        <div
                            class="items-center{{ $column->sortable && $datatable->isSortable() ? 'cursor-pointer' : '' }} flex gap-x-2"
                            @if ($column->sortable && $datatable->isSortable()) wire:click="sortBy('{{ $column->name }}', '{{ $datatable->sortDir === 'desc' ? 'asc' : 'desc' }}')" @endif
                        >

                            <span
                                class="whitespace-nowrap text-xs">{!! $column->label !!}</span>

                            @if ($column->sortable && $datatable->isSortable())
                                <span class="flex text-xs leading-none">
                                    <button
                                        type="button"
                                        class="link-info-lg {{ $datatable->isCurrentSortingColumn($column, 'asc') }}"
                                    >
                                        <i class="fa-solid fa-sort"></i>
                                    </button>

                                    {{-- <button type="button" class="link-info-lg {{ $datatable->isCurrentSortingColumn($column, 'desc') ?: 'text-gray-400' }}">
                                <i class="fa-solid fa-sort"></i>
                            </button> --}}
                                </span>
                            @endif

                        </div>
                    </td>
                @endforeach

            </tr>

        </thead>
        <tbody class="table-body">
            @forelse($records as $key => $entity)
                <tr
                    class="table-body-row"
                    wire:key="{{ "datatable-record-#$key" }}"
                >
                    @foreach ($datatable->columns()->where('visibility', true) as $column)
                        <td
                            x-cloak
                            class="table-body-cell"
                        >
                            @if ($column->name === 'actions')
                                <div class="flex gap-x-3">
                                    @foreach ($datatable->actions() as $action)
                                        <div>
                                            {!! $action->render($entity) !!}
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                {!! $column->render($entity) !!}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr
                    class="table-body-row"
                    wire:key="datatable-no-records"
                >
                    <td
                        colspan="{{ $datatable->columns()->count() ?? 1 }}"
                        class="text-black-light block w-full text-lg lg:table-cell"
                    >
                        <div
                            class="flex flex-col items-center justify-center py-7">
                            <div>
                                <img
                                    src="{{ asset('img/no_data_icon.svg') }}"
                                    alt="no data icon"
                                >
                            </div>

                            <div class="pt-3 text-green-700">
                                No data found
                            </div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    @if ($datatable->paginate && $records->total() > (count($datatable->pageLengthMenu()) ? $datatable->pageLengthMenu()[0] : $datatable->pageLength))
        <div class="pagination-wrapper flex flex-wrap items-center justify-end">
            <div class="w-full sm:w-auto">
                {{ $records->links() }}
            </div>
        </div>
    @endif
</div>

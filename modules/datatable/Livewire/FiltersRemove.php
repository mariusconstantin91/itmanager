<?php

namespace Modules\DataTable\Livewire;

use Livewire\Component;
use Modules\DataTable\Core\Abstracts\DataTable;
use Modules\DataTable\Livewire\Traits\SyncWithDatatable;

/**
 * Class Filters
 */
class FiltersRemove extends Component
{
    use SyncWithDatatable;

    /**
     * The datatable id
     *
     * @var string
    */
    public string $datatableId;

    /**
     * The datatable
     *
     * @var \Modules\DataTable\Core\Abstracts\DataTable
    */
    protected DataTable $datatable;

    /**
     * The mount hook
     *
     * @param  \Modules\DataTable\Core\Abstracts\DataTable  $datatableClass
     * @return void
     */
    public function mount(DataTable $datatableClass)
    {
        $this->datatableId = $datatableClass->id;
        $this->datatable = $datatableClass;
        $this->syncWithDataTable('cacheDataTable');
    }

    /**
     * The booted hook
     *
     * @return void
     */
    public function booted()
    {
        $this->syncWithDataTable('getCachedDataTable');
    }

    /**
     * Remove filters event
     *
     * @return void
     */
    public function removeFilters()
    {
        $this->emitTo('datatable::filters', 'resetFilters', $this->datatableId);
    }

    /**
     * Render function
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('datatable::filters-remove', [
            'datatable' => $this->datatable,
        ]);
    }
}

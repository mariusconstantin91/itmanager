<?php

namespace Modules\DataTable\Livewire;

use Livewire\Component;
use Modules\DataTable\Core\Abstracts\DataTable;
use Modules\DataTable\Livewire\Traits\SyncWithDatatable;

/**
 * Class Filters
 */
class Filters extends Component
{
    use SyncWithDatatable;

    /**
     * The datatable id
     *
     * @var string
    */
    public string $datatableId;

    /**
     * Fitlers
     *
     * @var array
    */
    public array $filters = [];

    /**
     * The datatable
     *
     * @var \Modules\DataTable\Core\Abstracts\DataTable
    */
    protected DataTable $datatable;

    protected $listeners = ['resetFilters'];

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
        if ($this->datatable->filters->hasValues()) {
            $this->filters = $this->datatable->filters->getValues()->toArray();
        }
    }

    /**
     * The booted hook
     *
     * @return void
     */
    public function booted()
    {
        $this->syncWithDataTable('getCachedDataTable');
        $this->syncWithDataTable('queryStringFilters');
    }

    /**
     * Catch filters update
     *
     * @return void
     */
    public function updatedFilters()
    {
        $this->emitTo(
            'datatable::datatable',
            'setFilters',
            $this->filters,
            $this->datatableId
        );
    }

    /**
     * Reset the filters
     *
     * @param string $datatableId
     * @return void
     */
    public function resetFilters(string $datatableId)
    {
        if ($datatableId === $this->datatableId) {
            $this->reset('filters');
            $this->emitTo(
                'datatable::datatable',
                'setFilters',
                $this->filters,
                $this->datatableId
            );
        }
    }

    /**
     * Remove the filters
     *
     * @return void
     */
    public function removeFilters()
    {
        $this->emitTo('datatable::filters', 'resetFilters', $this->datatableId);
    }

    /**
     * The render
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('datatable::filters', [
            'datatable' => $this->datatable,
        ]);
    }
}

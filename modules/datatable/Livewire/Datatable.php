<?php

namespace Modules\DataTable\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\DataTable\Livewire\Traits\SyncWithDatatable;

/**
 * Class Datatable
 */
class Datatable extends Component
{
    use WithPagination, SyncWithDatatable;

    /**
     * Number if items on page
     *
     * @var int|null
    */
    public ?int $pageLength = null;

    /**
     * Search
     *
     * @var string
    */
    public string $search = '';

    /**
     * Filters
     *
     * @var array
    */
    public array $filters = [];

    /**
     * Sort by default
     *
     * @var
    */
    public string $sortBy = '';

    /**
     * Sort direction
     *
     * @var
    */
    public string $sortDir = '';

    /**
     * If of datatable
     *
     * @var string
    */
    public string $datatableId = '';

    /**
     * The datatable
     *
     * @var \Modules\DataTable\Core\Abstracts\DataTable
    */
    protected \Modules\DataTable\Core\Abstracts\DataTable $datatable;

    /**
     * The listeners
     *
     * @return string[]
     */
    public function getListeners(): array
    {
        return [
            'setFilters',
            'removeFilters',
            'setSearch',
            'refresh' => '$refresh',
        ];
    }

    /**
     * The mont hook
     *
     * @param $datatableClass
     * @return void
     */
    public function mount($datatableClass)
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
        $this->syncWithDataTable('queryString');
        $this->syncWithDataTable();
    }

    /**
     * The render hook
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->syncWithDataTable();
        $this->syncWithDataTable('cacheDataTable');

        return view('datatable::datatable', $this->datatable->viewData());
    }

    /**
     * Set the search
     *
     * @param $search
     * @param  string  $datatableId
     * @return void
     */
    public function setSearch($search, string $datatableId)
    {
        if ($datatableId === $this->datatableId) {
            $this->search = $search;
            $this->syncWithDataTable('search');
        }
    }

    /**
     * Set the sort by
     *
     * @param  string  $name
     * @param  string  $dir
     * @return void
     */
    public function sortBy(string $name, string $dir = 'asc'): void
    {
        $this->sortBy = $name;
        $this->sortDir = $dir;
        $this->syncWithDataTable('sort');
    }

    /**
     * Set filters
     *
     * @param $values
     * @param  string  $datatableId
     * @return void
     */
    public function setFilters($values, string $datatableId)
    {
        if ($datatableId === $this->datatableId) {
            $this->filters = $values;
            $this->syncWithDataTable('filters');
        }
    }

    /**
     * Remove filters
     *
     * @param  string  $datatableId
     * @return void
     */
    public function removeFilters(string $datatableId)
    {
        if ($datatableId === $this->datatableId) {
            $this->reset('filters');
            $this->emitTo('datatable::filters', 'refresh', $this->datatableId);
            $this->syncWithDataTable('filters');
        }
    }

    /**
     * Update the page lenght
     *
     * @param $pageLength
     * @return void
     */
    public function updatedPageLength($pageLength): void
    {
        $this->pageLength = $pageLength;
        $this->syncWithDataTable('pagination');
    }

    /**
     * Delete action
     *
     * @param $id
     * @param  bool  $confirmed
     * @return bool|void
     */
    public function deleteAction($id, bool $confirmed = false)
    {
        $deleteAction = $this->datatable
            ->actions()
            ->firstWhere('name', 'delete');

        if ($deleteAction) {
            if ($deleteAction->requireConfirmation && !$confirmed) {
                $this->dispatchBrowserEvent(
                    "show-delete-datatable-record-modal-$id"
                );

                return false;
            }

            if ($entity = $this->datatable->model::find($id)) {
                $status = true;
                $message = '';
                if (method_exists($this->datatable, 'beforeDeleteActionPerformed')) {
                    $status = $this->datatable->beforeDeleteActionPerformed($entity);
                } else {
                    $this->emitUp('beforeDeleteActionPerformed', $entity);
                }

                if ($status) {
                    if ($entity->delete()) {
                        $this->emitUp('afterDeleteActionPerformed', $entity);

                        return true;
                    }
                } else {
                    $this->emitUp('errorMessage', $message);
                    return false;
                }
            }
        }
    }
}

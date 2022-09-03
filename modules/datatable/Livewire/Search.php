<?php

namespace Modules\DataTable\Livewire;

use Livewire\Component;
use Modules\DataTable\Core\Abstracts\DataTable;
use Modules\DataTable\Livewire\Traits\SyncWithDatatable;

/**
 * Class Search
 */
class Search extends Component
{
    use SyncWithDatatable;

    /**
     * The datatable id
     *
     * @var string
    */
    public string $datatableId;

    /**
     * The search
     *
     * @var string
    */
    public string $search = '';

    /**
     * The title
     *
     * @var string
    */
    public string $title = 'Search';

    /**
     * The description
     *
     * @var string|null
    */
    public string|null $description = null;

    /**
     * The placeholder
     *
     * @var string
    */
    public string $placeholder = 'Enter search term';

    /**
     * Flag to show reset button
     *
     * @var bool
    */
    public bool $showResetButton = true;

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
     * @param  string  $title
     * @param  string|null  $description
     * @param  string  $placeholder
     * @param  bool  $showResetButton
     * @return void
     */
    public function mount(
        DataTable $datatableClass,
        string $title = 'Search',
        string $description = null,
        string $placeholder = 'Enter search term',
        bool $showResetButton = true
    )
    {
        $this->datatableId = $datatableClass->id;
        $this->title = $title;
        $this->description = $description;
        $this->placeholder = $placeholder;
        $this->showResetButton = $showResetButton;

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
     * Catch the change on search property
     *
     * @return void
     */
    public function updatedSearch()
    {
        $this->emitTo(
            'datatable::datatable',
            'setSearch',
            $this->search,
            $this->datatableId
        );
    }

    /**
     * Reset the search
     *
     * @return void
     */
    public function resetSearch(): void
    {
        $this->reset('search');
        $this->emitTo(
            'datatable::datatable',
            'setSearch',
            $this->search,
            $this->datatableId
        );
    }

    /**
     * Render
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->syncWithDataTable('queryStringSearch');

        return view('datatable::search', [
            'datatable' => $this->datatable,
        ]);
    }
}

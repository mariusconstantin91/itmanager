<?php

namespace Modules\DataTable\View\DataTable;

use Illuminate\View\Component;

/**
 * Class Layout
 */
class Layout extends Component
{
    /**
     * Datatable classes
     *
     * @var
    */
    public $datatableClass;

    /**
     * The title
     *
     * @var string|null
    */
    public ?string $title;

    /**
     * Show remove filter button flag
     *
     * @var bool
    */
    public bool $showRemoveFiltersButton;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $datatableClass,
        string $title = null,
        bool $showRemoveFiltersButton = true
    )
    {
        $this->datatableClass = $datatableClass;
        $this->title = $title;
        $this->showRemoveFiltersButton = $showRemoveFiltersButton;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('datatable::components.layout');
    }
}

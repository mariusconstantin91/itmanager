<?php

namespace Modules\DataTable;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\DataTable\Commands\MakeDataTable;
use Modules\DataTable\Livewire\Datatable;
use Modules\DataTable\Livewire\Filters;
use Modules\DataTable\Livewire\FiltersRemove;
use Modules\DataTable\Livewire\Search;

/**
 * Class DataTableServiceProvider
 */
class DataTableServiceProvider extends ServiceProvider
{
    /**
     * The book method
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([MakeDataTable::class]);

        $this->loadViewsFrom(__DIR__ . '/views/datatable', 'datatable');
        $this->loadViewsFrom(__DIR__ . '/views/table', 'table');
    }

    /**
     * The register method
     *
     * @return void
     */
    public function register()
    {
        Livewire::component('datatable::datatable', Datatable::class);
        Livewire::component('datatable::search', Search::class);
        Livewire::component('datatable::filters', Filters::class);
        Livewire::component('datatable::filters.remove', FiltersRemove::class);

        Blade::componentNamespace(
            'Modules\\DataTable\\View\\DataTable',
            'datatable'
        );
        Blade::componentNamespace('Modules\\DataTable\\View\\Table', 'table');
    }
}

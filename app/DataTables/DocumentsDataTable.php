<?php
namespace App\DataTables;

use App\Models\Document;
use Illuminate\Database\Eloquent\Builder;
use Modules\DataTable\Core\Facades\Action;
use Modules\DataTable\Core\Facades\Column;
use Modules\DataTable\Core\Abstracts\DataTable;
use Modules\DataTable\Core\Actions\DeleteAction;
use Modules\DataTable\Core\Actions\EditAction;
use Modules\DataTable\Core\Facades\Filter;

/**
 * Class DocumentsDataTable
 *
 * @package App\DataTables
 */
class DocumentsDataTable extends DataTable
{
    /**
     * The main entity of the table
     *
     * @var string
    */
    public string $model = Document::class;

     /**
     * The name of the component
     *
     * @var string
     */
    public string $name = 'DocumentsDataTable';

   /**
     * Default sort order : 'desc' | 'asc'
     *
     * @var string
     */
    public string $sortDir = 'desc';

    /**
     * The column name for defaut sort
     *
     * @var string
     */
    public string $sortBy = 'created_at';

    /**
     * Display Search, Filters, Sorting and Pagination properties in url
     *
     * @var bool
     */
    public bool $hasQueryStrings = true;

    /**
     * Enable the pagination: true | false
     *
     * @var bool
     */
    public bool $paginate = true;

   /**
     * The number of items per page 10 | 25 | 50 | 100
     *
     * @var int
     */
    public int $pageLength = 10;

    /**
     * Enable search
     *
     * @var bool
     */
    public bool $enableSearch = true;

    /**
     * Enable Sorting
     *
     * @var bool
     */
    public bool $enableSorting = true;

    /**
     * Enable Filters
     *
     * @var bool
     */
    public bool $enableFilters = true;

   /**
     * Enable Reset Filters Button
     *
     * @var bool
     */
    public bool $enableResetFilters = true;

    /**
     * The initial setup for datatable, function call when the compoment is initialized
     *
     * @return void
     */
    public function init()
    {
        // Set your columns
        $this->setColumns([
            Column::ID()->setVisibility(false),
            Column::text('created_at')->setVisibility(false),
            Column::text('name'),
            Column::text('type'),
            Column::view('path')
                ->setSearchable(false)
                ->setSortable(false)
                ->setView('datatable::columns.documents_path'),
            Column::text('user.name')
            ->setSortRelationship('users', 'users.name', 'user_id', 'users.id'),
            Column::text('approveUser.name', 'approveUser.name', 'Approved by')
            ->setSortRelationship('users', 'users.name', 'user_id', 'users.id'),
            Column::selectArray('status')
                ->setOptions(
                    Document::STATUS_OPTIONS
                ),
        ]);

        // Set your filters
        $this->setFilters([
            Filter::text('name', 'name', 'Name'),
            Filter::text('type', 'type', 'Type'),
            Filter::text('user', 'name', 'User', 'user', 'name'),
            Filter::multiple('status', 'status', 'Status')
                ->setOptions(
                    Document::STATUS_OPTIONS
                ),
        ]);

        // Set your actions
        $this->setActions([
            Action::edit('documents.edit', ['document' => 'id'])->setRenderCallback(function ($entity) {
                if ($entity->status == 'approved') {
                    return '';
                }
                return (new EditAction('documents.edit', ['document' => 'id']))->resolveData($entity);
            }),
            Action::delete()->setRenderCallback(function ($entity) {
                if ($entity->status == 'approved') {
                    return '';
                }
                return (new DeleteAction())->resolveData($entity);
            }),
        ]);
    }

    /**
     * The Query builder which return the data for the table
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Builder $query): Builder
    {
        return $query->with('user', 'approveUser');
    }
}

<?php

namespace Modules\DataTable\Core\Actions;

use Modules\DataTable\Core\Abstracts\DataTableAction;

/**
 * Class DeleteAction
 */
class DeleteAction extends DataTableAction
{
    /**
     * The name of the action
     *
     * @var string
    */
    public string $name = 'delete';

    /**
     * The diplayed text of the action
     *
     * @var string
    */
    public string $text = 'Delete';

    /**
     * The primary key for the action
     *
     * @var string
    */
    public string $primaryKey = 'id';

    /**
     * Flag to know if the confirmation is required
     *
     * @var bool
    */
    public bool $requireConfirmation = true;

    /**
     * The construct
     *
     * @param  string|null  $name
     */
    public function __construct(string $name = null)
    {
        parent::__construct($name ?? $this->name);
    }

    /**
     * Render the action
     *
     * @param $entity
     * @return string
     */
    public function resolveData($entity)
    {
        return view('datatable::actions.delete', [
            'action' => $this,
            'entity' => $entity,
            'primaryKey' => $this->primaryKey,
        ])->render();
    }

    /**
     * Set primary key
     *
     * @param $primaryKey
     * @return $this
     */
    public function setPrimaryKey($primaryKey): self
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }

    /**
     * Set require confirmation
     *
     * @param  bool  $requireConfirmation
     * @return $this
     */
    public function setRequireConfirmation(bool $requireConfirmation)
    {
        $this->requireConfirmation = $requireConfirmation;

        return $this;
    }
}

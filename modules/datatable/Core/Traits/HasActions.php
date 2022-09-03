<?php

namespace Modules\DataTable\Core\Traits;

use Modules\DataTable\Core\Collections\ActionsCollection;

/**
 * Trait HasActions
 */
trait HasActions
{
    /**
     * Enable actions
     *
     * @var bool
    */
    public bool $enableActions = true;

    /**
     * Actions
     *
     * @var \Modules\DataTable\Core\Collections\ActionsCollection
    */
    public ActionsCollection $actions;

    /**
     * Get the actions
     *
     * @return \Modules\DataTable\Core\Collections\ActionsCollection
     */
    public function actions()
    {
        return $this->actions;
    }

    /**
     * Set the actions
     *
     * @param  array  $actions
     * @return $this
     */
    public function setActions(array $actions): self
    {
        $this->actions = ActionsCollection::make($actions);

        return $this;
    }

    /**
     * Check if has actions
     *
     * @return bool
     */
    public function hasActions(): bool
    {
        return $this->enableActions && $this->actions->isNotEmpty();
    }
}

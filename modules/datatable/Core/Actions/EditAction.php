<?php

namespace Modules\DataTable\Core\Actions;

use Modules\DataTable\Core\Abstracts\DataTableAction;

/**
 * Class EditAction
 */
class EditAction extends DataTableAction
{
    /**
     * The name of action
     *
     * @var string
    */
    public string $name = 'edit';

    /**
     * The dispalyed text of action
     *
     * @var string
    */
    public string $text = 'Edit';

    /**
     * The route of action
     *
     * @var string|null
    */
    public string|null $route;

    /**
     * Route parameters
     *
     * @var array
    */
    public array $routeParameters = [];

    /**
     * The constructor
     *
     * @param  string  $route
     * @param  array  $routeParameters
     * @param  string|null  $name
     */
    public function __construct(
        string $route,
        array $routeParameters = [],
        string $name = null
    )
    {
        $this->route = $route;
        $this->routeParameters = $routeParameters;
        parent::__construct($name ?? $this->name);
    }

    /**
     * The render for action
     *
     * @param $entity
     * @return string
     */
    public function resolveData($entity)
    {
        return view('datatable::actions.edit', [
            'action' => $this,
            'entity' => $entity,
        ])->render();
    }

    /**
     * Get the route
     *
     * @param $entity
     * @return string
     */
    public function getRoute($entity)
    {
        $parameters = collect($this->routeParameters)
            ->mapWithKeys(function ($attribute, $parameter) use ($entity) {
                return [$parameter => $entity->{$attribute} ?? null];
            })
            ->toArray();

        return route($this->route, $parameters);
    }

    /**
     * Set the route
     *
     * @param  string  $route
     * @param  string[]  $routeParameters
     * @return $this
     */
    public function setRoute(string $route, array $routeParameters)
    {
        $this->route = $route;
        $this->routeParameters = $routeParameters;

        return $this;
    }
}

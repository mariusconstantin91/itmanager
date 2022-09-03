<?php

namespace Modules\DataTable\Core\Actions;

use Modules\DataTable\Core\Abstracts\DataTableAction;

/**
 * Class LinkAction
 */
class LinkAction extends DataTableAction
{
    /**
     * The route
     *
     * @var string
    */
    public string $route;

    /**
     * The route parameters
     *
     * @var array
    */
    public array $routeParameters = [];

    /**
     * The render
     *
     * @param $entity
     * @return string
     */
    public function resolveData($entity)
    {
        return "<a href='{$this->getRoute(
            $entity
        )}' {$this->renderAttributes()}>{$this->text}</a>";
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
        
        try {
            return route($this->route, $parameters);
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Set the route
     *
     * @param  string  $route
     * @param  string[]  $routeParameters
     * @return $this
     */
    public function setRoute(string $route, array $routeParameters = [])
    {
       
        $this->route = $route;
        $this->routeParameters = $routeParameters;
        return $this;
    }
}

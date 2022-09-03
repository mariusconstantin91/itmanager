<?php

namespace Modules\DataTable\Core\Abstracts;

use Closure;
use Exception;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Modules\DataTable\Core\Interfaces\DataTableColumnInterface;
use Modules\DataTable\Core\Traits\Serializable;

/**
 * Class DataTableColumn
 */
abstract class DataTableColumn implements DataTableColumnInterface
{
    use Serializable;

    /**
     * The serialization of the datatable
     *
     * @var string
    */
    private static string $serializationSecretKey =
        'datatables_columns_' . self::class;

    /**
     * The type of column
     *
     * @var string
    */
    public string $type;

    /**
     * The name of column
     *
     * @var string
    */
    public string $name;

    /**
     * The attributes of column
     *
     * @var string
    */
    public string $attribute;

    /**
     * The label of column
     *
     * @var string
    */
    public string $label;

    /**
     * The render call back
     *
     * @var Closure|null
    */
    public ?Closure $renderCallback = null;

    /**
     * Flag to skip custom formating render callback
     *
     * @var bool
    */
    public bool $renderCallbackSkipCustomFormatting = false;

    /**
     * Flag for searchable
     *
     * @var bool
    */
    public bool $searchable = true;

    /**
     * Flag for sortable
     *
     * @var bool
    */
    public bool $sortable = true;

    /**
     * Flag for filterable
     *
     * @var bool
    */
    public bool $filterable = false;

    /**
     * Flag for visibility
     *
     * @var bool
    */
    public bool $visibility = true;

    /**
     * The relationships
     *
     * @var string[]
    */
    public array $relationships;

    /**
     * The route for column
     *
     * @var string
    */
    public string $route;

    /**
     * The route parameters for column
     *
     * @var array
    */
    public array $routeParameters = [];

    /**
     * Variables needed for sort relationships
    */
    public string $relatedTable;

    public string $firstJoinCondition;

    public string $secondJoinCondition;

    public string $sortColumn;

    /**
     * Set the route and route parameters
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

    /**
     * Set the parameters for relation sort
     *
     * @param string $relatedTable
     * @param string $sortColumn
     * @param string $firstJoinCondition
     * @param string $secondJoinCondition
     * @return void
     */
    public function setSortRelationship(
        string $relatedTable,
        string $sortColumn,
        string $firstJoinCondition,
        string $secondJoinCondition
    )
    {
        $this->relatedTable = $relatedTable;
        $this->sortColumn = $sortColumn;
        $this->firstJoinCondition = $firstJoinCondition;
        $this->secondJoinCondition = $secondJoinCondition;
        $this->sortColumn = $sortColumn;

        return $this;
    }

    /**
     * The the route
     *
     * @param $entity
     * @return string
     */
    public function getRoute($entity)
    {
        if (isset($this->route)) {
            $parameters = collect($this->routeParameters)
                ->mapWithKeys(function ($attribute, $parameter) use ($entity) {
                    return [$parameter => $entity->{$attribute} ?? null];
                })
                ->toArray();

            return route($this->route, $parameters);
        }

        return null;
    }

    /**
     * The constructor of the column
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @param  string|null  $label
     */
    public function __construct(
        string $name,
        string $attribute = null,
        string $label = null
    )
    {
        $this->name = $name;
        $this->attribute = $attribute ?? $name;
        $this->label = $this->makeLabel($label ?? ($attribute ?? $name));

        $this->relationships = $this->extractRelationshipFromAttribute();

        return $this;
    }

    /**
     * Create the label based on name
     *
     * @param $name
     * @return string
     */
    protected function makeLabel($name): string
    {
        return ucwords(Str::replace(['-', '_', '.'], ' ', $name));
    }

    /**
     * Get the relation from attribute
     *
     * @return array
     */
    private function extractRelationshipFromAttribute(): array
    {
        if ($this->attributeContainsRelationship()) {
            $relationship = collect(explode('.', $this->attribute));
            $relationship->pop();

            if ($relationship->count()) {
                return $relationship->toArray();
            }
        }

        return [];
    }

    /**
     * Check if the attribute contains relationships
     *
     * @return bool
     */
    private function attributeContainsRelationship(): bool
    {
        return Str::contains($this->attribute, '.');
    }

    /**
     * Set the type
     *
     * @param  string  $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the attribute
     *
     * @param  string  $attribute
     * @return $this
     */
    public function setAttribute(string $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Set the label
     *
     * @param  string  $label
     * @return $this
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Set the relatedTable
     *
     * @param  string  $relatedTable
     * @return $this
     */
    public function setRelatedTable(string $relatedTable): self
    {
        $this->relatedTable = $relatedTable;

        return $this;
    }

    /**
     * Set the renderCallback
     *
     * @param  \Closure  $renderCallback
     * @param  bool  $skipCustomFormatting
     * @return $this
     */
    public function setRenderCallback(
        Closure $renderCallback,
        bool $skipCustomFormatting = false
    ): self
    {
        $this->renderCallback = $renderCallback;
        $this->renderCallbackSkipCustomFormatting = $skipCustomFormatting;

        return $this;
    }

    /**
     * Set the seachable flag
     *
     * @param  bool  $searchable
     * @return $this
     */
    public function setSearchable(bool $searchable): self
    {
        $this->searchable = $searchable;

        return $this;
    }

    /**
     * Set the sortable flag
     *
     * @param  bool  $sortable
     * @return $this
     */
    public function setSortable(bool $sortable): self
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * Set the filtrable flag
     *
     * @param  bool  $filterable
     * @return $this
     */
    public function setFilterable(bool $filterable): self
    {
        $this->filterable = $filterable;

        return $this;
    }

    /**
     * Set the visibility
     *
     * @param  bool  $visibility
     * @return $this
     */
    public function setVisibility(bool $visibility): self
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Set the render
     *
     * @param $entity
     * @return null
     */
    public function render($entity)
    {
        if (isset($this->renderCallback)) {
            if ($this->renderCallbackSkipCustomFormatting &&
                $this->isRenderCallbackReturnTypeSupported(
                    $data = $this->resolveRenderCallback($entity)
                )
            ) {
                return (string) $data;
            }

            return $this->resolveData(
                $this->resolveRenderCallback($entity),
                $entity
            );
        } else {
            if (is_object($entity) || is_array($entity)) {
                $data = is_array($entity) ? (object) $entity : $entity;

                if (isset($this->relationships)) {
                    $result = $data;
                    foreach ($this->relationships as $relationship) {
                        if ($result && method_exists($result, $relationship)) {
                            $result = $result->{$relationship}()->first();
                        }
                    }

                    if ($result) {
                        return $this->resolveData(
                            $result->{$this->extractAttributeWithoutRelationship()},
                            $data
                        );
                    }
                }

                return $this->resolveData($data->{$this->attribute}, $data);
            }
        }

        return null;
    }

    /**
     * Check if the render callback return is a supported type
     *
     * @param $data
     * @return bool|mixed
     */
    private function isRenderCallbackReturnTypeSupported($data)
    {
        $given_type = gettype($data);

        try {
            settype($data, 'string');

            return true;
        } catch (Exception $exception) {
            return static::unsupportedRenderCallbackReturnType(
                $given_type,
                $this->attribute
            );
        }
    }

    /**
     * Error for unsupported type
     *
     * @param  string  $given_type
     * @param  string  $columnAttribute
     * @static
     * @return mixed
     */
    private static function unsupportedRenderCallbackReturnType(
        string $given_type,
        string $columnAttribute
    ): mixed
    {
        return throw new InvalidArgumentException(
            "Given type '$given_type' cannot be converted to 'string'." .
                "Make sure your \$renderCallback for column '$columnAttribute' is returning 'string' or other
                 supported types to perform the conversion or set \$renderCallbackSkipCustomFormatting 
                 parameter to 'false' when setting the \$renderCallback."
        );
    }

    /**
     * Resolve render callback
     *
     * @param $entity
     * @return mixed
     */
    public function resolveRenderCallback($entity): mixed
    {
        if (isset($this->renderCallback)) {
            return $this->renderCallback->call($this, $entity);
        }

        return null;
    }

    /**
     * Return the data for column
     *
     * @param $data
     * @param $entity
     * @return string
     */
    public function resolveData($data, $entity)
    {
        if ($route = $this->getRoute($entity)) {
            return "<a href='$route' class='link-info'>$data</a>";
        }

        return $data;
    }

    /**
     * Extract attribute for relation
     *
     * @return string
     */
    public function extractAttributeWithoutRelationship(): string
    {
        return collect(explode('.', $this->attribute))->last();
    }

    /**
     * Check if the column is visible
     *
     * @return bool
     */
    private function isVisible($data)
    {
        $data = $data; //skip the phpcs warning
        return $this->visibility;
    }
}

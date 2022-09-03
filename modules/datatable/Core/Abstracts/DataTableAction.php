<?php

namespace Modules\DataTable\Core\Abstracts;

use Closure;
use Exception;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Modules\DataTable\Core\Traits\Serializable;

/**
 * Class DataTableAction
 */
abstract class DataTableAction
{
    use Serializable;

    /**
     * The serialization of the datatable
     *
     * @var string
    */
    private static string $serializationSecretKey =
        'datatables_actions_' . self::class;

    /**
     * The name
     *
     * @var string
    */
    public string $name;

    /**
     * Closure to get the data
     *
     * @var \Closure
    */
    public Closure $renderCallback;

    /**
     * The text displayed for action
     *
     * @var string
    */
    public string $text;

    /**
     * Attributes of the action
     *
     * @var array
    */
    public array $attributes = [];

    /**
     * The constructor of the action
     *
     * @param  string  $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->text = $this->makeText($name);
    }

    /**
     * Transform the name in text
     *
     * @param $name
     * @return string
     */
    protected function makeText($name): string
    {
        return ucwords(Str::replace(['-', '_', '.'], ' ', $name));
    }

    /**
     * Set tender callback
     *
     * @param  \Closure  $renderCallback
     * @return $this
     */
    public function setRenderCallback(Closure $renderCallback): self
    {
        $this->renderCallback = $renderCallback;

        return $this;
    }

    /**
     * Set attributes
     *
     * @param  array  $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Set render attributes
     *
     * @return string
     */
    public function renderAttributes(): string
    {
        return collect($this->attributes)
            ->map(function ($value, $attribute) {
                return "$attribute=\"$value\"";
            })
            ->implode(' ');
    }

    /**
     * Set Text
     *
     * @param  string  $text
     * @return $this
     */
    public function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Set render
     *
     * @param $entity
     * @return null
     */
    public function render($entity)
    {
        if (isset($this->renderCallback) &&
            $this->isRenderCallbackReturnTypeSupported(
                $data = $this->resolveRenderCallback($entity)
            )
        ) {
            return (string) $data;
        } else {
            if (is_object($entity) || is_array($entity)) {
                $data = is_array($entity) ? (object) $entity : $entity;

                return $this->resolveData($data);
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
                $this->name
            );
        }
    }

    /**
     * Error for unsupported type
     *
     * @param  string  $given_type
     * @param  string  $action
     * @static
     * @return mixed
     */
    private static function unsupportedRenderCallbackReturnType(
        string $given_type,
        string $action
    ): mixed
    {
        return throw new InvalidArgumentException(
            "Given type '$given_type' cannot be converted to 'string'." .
                "Make sure your \$renderCallback for action '$action' is returning 'string' or other supported 
                types to perform the conversion."
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
            return $this->renderCallback->call($this, $entity, $this);
        }

        return null;
    }
}

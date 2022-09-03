<?php

namespace Modules\DataTable\Core\Facades;

use Exception;
use InvalidArgumentException;
use Modules\DataTable\Core\Filters\BooleanColumnFilter;
use Modules\DataTable\Core\Filters\DateColumnFilter;
use Modules\DataTable\Core\Filters\DatetimeColumnFilter;
use Modules\DataTable\Core\Filters\EmailColumnFilter;
use Modules\DataTable\Core\Filters\IDColumnFilter;
use Modules\DataTable\Core\Filters\MultipleColumnFilter;
use Modules\DataTable\Core\Filters\TextColumnFilter;
use Modules\DataTable\Core\Filters\TimeColumnFilter;
use Modules\DataTable\Core\Filters\SelectArrayColumnFilter;
use ReflectionMethod;

/**
 * Class Filter
 *
 * @method static IDColumnFilter id(?string $name = null, ?string $attribute = null, ?string $label = null)
 * @method static TextColumnFilter text(string $name, string $attribute, ?string $label = null)
 * @method static EmailColumnFilter email(string $name, string $attribute, ?string $label = null)
 * @method static BooleanColumnFilter boolean(string $name, string $attribute, ?string $label = null)
 * @method static DatetimeColumnFilter datetime(string $name, string $attribute, ?string $label = null)
 * @method static DateColumnFilter date(string $name, string $attribute, ?string $label = null)
 * @method static TimeColumnFilter time(string $name, string $attribute, ?string $label = null)
 * @codingStandardsIgnoreStart
 * @method static MultipleColumnFilter multiple(string $name, string $attribute, ?string $label = null, string $relationship = null, string $column = null)
 * @method static MultipleColumnFilter multiple(string $name, string $attribute, ?string $label = null, string $relationship = null, string $column = null)
 */
class Filter
{
    /**
     * Available filter types
     *
     * @var array|string[]
    */
    public static array $available_filters = [
        'id' => IDColumnFilter::class,
        'text' => TextColumnFilter::class,
        'email' => EmailColumnFilter::class,
        'boolean' => BooleanColumnFilter::class,
        'datetime' => DatetimeColumnFilter::class,
        'date' => DateColumnFilter::class,
        'time' => TimeColumnFilter::class,
        'multiple' => MultipleColumnFilter::class,
        'selectArray' => SelectArrayColumnFilter::class,
    ];

    /**
     * Ability to call them statically
     *
     * @param $filterType
     * @param $arguments
     * @return \Modules\DataTable\Core\Facades\Column|mixed
     * @static
     * @throws \Exception
     */
    public static function __callStatic($filterType, $arguments)
    {
        if (!in_array($filterType, array_keys(static::$available_filters))) {
            return static::missingFilterTypeException($filterType);
        }

        $filterClass = static::$available_filters[$filterType];

        $params = (new ReflectionMethod(
            $filterClass,
            '__construct'
        ))->getParameters();
        $params_collection = collect($params);
        $constructor_arguments = [];
        $corrupt_arguments = [];

        foreach ($arguments as $key => $value) {
            $param = $params_collection
                ->filter(function ($param) use ($key) {
                    return $param->getPosition() === $key;
                })
                ->first();
            if ($param) {
                if (!$param->hasType() ||
                    ($param->getType()->allowsNull() ||
                        (!$param->getType()->allowsNull() &&
                            $param->getType()->getName() === gettype($value)))
                ) {
                    $constructor_arguments[$param->getName()] = $value;
                } else {
                    $corrupt_arguments[] = [
                        'param' => $param,
                        'given_value' => $value,
                        'given_value_is_null' => is_null($value),
                        'given_type' => gettype($value),
                    ];
                }
            }
        }

        $missing_arguments = $params_collection
            ->filter(function ($param) use ($constructor_arguments) {
                return !$param->isOptional() &&
                    !in_array(
                        $param->getName(),
                        array_keys($constructor_arguments)
                    );
            })
            ->toArray();

        if (count($corrupt_arguments)) {
            return static::corruptFilterArguments(
                $filterClass,
                '__construct',
                $corrupt_arguments,
                $params
            );
        }

        if (count($missing_arguments)) {
            return static::missingFilterArguments(
                $filterClass,
                '__construct',
                $missing_arguments,
                $params
            );
        }

        return new $filterClass(...array_values($constructor_arguments));
    }

    /**
     * Missing filter type exception
     *
     * @param  string  $type
     * @return mixed
     * @static
     * @throws \Exception
     */
    public static function missingFilterTypeException(string $type): mixed
    {
        return throw new Exception(
            "Filter type '$type' doesn't exist in available filter types: [ '" .
                collect(self::$available_filters)
                    ->keys()
                    ->implode("', '") .
                "' ]"
        );
    }

    /**
     * Corrupt filter arguments
     *
     * @param  string  $class
     * @param  string  $called_function
     * @param  array  $corrupt_arguments
     * @param  array  $arguments
     *
     * @static
     *
     * @return mixed
     */
    public static function corruptFilterArguments(
        string $class,
        string $called_function,
        array $corrupt_arguments,
        array $arguments
    ): mixed
    {
        $corrupt_arguments = collect($corrupt_arguments)->implode(function (
            $item
        ) {
            return $item['param']->hasType()
                ? ($item['param']->getType()->allowsNull() ===
                    $item['given_value_is_null'] ?:
                        "Argument {$item['param']} is required.") .
                        ($item['param']->getType()->getName() ===
                        $item['given_type'] ?:
                            "Expected type '{$item['param']->getType()->getName()}', found '{$item['given_type']}'
                             for attribute {$item['param']}.")
                : '';
        },
        ' ');

        return throw new InvalidArgumentException(
            "$corrupt_arguments The class method requires the following $class::$called_function(" .
                implode(', ', $arguments) .
                ')'
        );
    }

    /**
     * Missing filter arguments
     *
     * @param  string  $class
     * @param  string  $called_function
     * @param  array  $missing_arguments
     * @param  array  $arguments
     * @return mixed
     * @static
     */
    public static function missingFilterArguments(
        string $class,
        string $called_function,
        array $missing_arguments,
        array $arguments
    ): mixed
    {
        $missing_arguments = collect($missing_arguments)->implode(function (
            $item
        ) {
            return "Parameter #{$item->getPosition()}";
        },
        ', ');

        return throw new InvalidArgumentException(
            "Arguments ($missing_arguments) are missing from the class method $class::$called_function(" .
                implode(', ', $arguments) .
                ')'
        );
    }
}

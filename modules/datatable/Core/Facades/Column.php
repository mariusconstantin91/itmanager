<?php

namespace Modules\DataTable\Core\Facades;

use Exception;
use InvalidArgumentException;
use Modules\DataTable\Core\Columns\BooleanColumn;
use Modules\DataTable\Core\Columns\DateColumn;
use Modules\DataTable\Core\Columns\DatetimeColumn;
use Modules\DataTable\Core\Columns\EmailColumn;
use Modules\DataTable\Core\Columns\IDColumn;
use Modules\DataTable\Core\Columns\ListColumn;
use Modules\DataTable\Core\Columns\MultipleColumn;
use Modules\DataTable\Core\Columns\TextColumn;
use Modules\DataTable\Core\Columns\TimeColumn;
use Modules\DataTable\Core\Columns\ViewColumn;
use Modules\DataTable\Core\Columns\SelectArrayColumn;
use ReflectionMethod;

/**
 * Class Column
 *
 * @method static IDColumn ID(?string $name = null, ?string $attribute = null, ?string $label = null)
 * @method static TextColumn text(string $name, ?string $attribute = null, ?string $label = null)
 * @method static EmailColumn email(string $name, ?string $attribute = null, ?string $label = null)
 * @method static BooleanColumn boolean(string $name, ?string $attribute = null, ?string $label = null)
 * @method static DatetimeColumn datetime(string $name, ?string $attribute = null, ?string $label = null)
 * @method static DateColumn date(string $name, ?string $attribute = null, ?string $label = null)
 * @method static TimeColumn time(string $name, ?string $attribute = null, ?string $label = null)
 * @method static ViewColumn view(string $name, ?string $attribute = null, ?string $label = null)
 * @method static SelectArrayColumn selectArray(string $name, ?string $attribute = null, ?string $label = null)
 */
class Column
{
    /**
     * Available columns
     *
     * @var array|string[]
    */
    public static array $available_columns = [
        'ID' => IDColumn::class,
        'text' => TextColumn::class,
        'email' => EmailColumn::class,
        'boolean' => BooleanColumn::class,
        'datetime' => DatetimeColumn::class,
        'date' => DateColumn::class,
        'time' => TimeColumn::class,
        'multiple' => MultipleColumn::class,
        'list' => ListColumn::class,
        'view' => ViewColumn::class,
        'selectArray' => SelectArrayColumn::class,
    ];

    /**
     * Ability to call columns static
     *
     * @param $columnType
     * @param $arguments
     * @return \Modules\DataTable\Core\Facades\Column|mixed
     *
     * @static
     * @throws \Exception
     */
    public static function __callStatic($columnType, $arguments)
    {
        if (!in_array($columnType, array_keys(static::$available_columns))) {
            return static::missingColumnTypeException($columnType);
        }

        $columnClass = static::$available_columns[$columnType];

        $params = (new ReflectionMethod(
            $columnClass,
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
            return static::corruptColumnArguments(
                $columnClass,
                '__construct',
                $corrupt_arguments,
                $params
            );
        }

        if (count($missing_arguments)) {
            return static::missingColumnArguments(
                $columnClass,
                '__construct',
                $missing_arguments,
                $params
            );
        }

        return new $columnClass(...array_values($constructor_arguments));
    }

    /**
     * Missing column type exception
     *
     * @param  string  $type
     * @return mixed
     *
     * @static
     *
     * @throws \Exception
     */
    public static function missingColumnTypeException(string $type): mixed
    {
        return throw new Exception(
            "Column type '$type' doesn't exist in available column types: [ '" .
                collect(self::$available_columns)
                    ->keys()
                    ->implode("', '") .
                "' ]"
        );
    }

    /**
     * Corrupt column arguments
     *
     * @param  string  $class
     * @param  string  $called_function
     * @param  array  $corrupt_arguments
     * @param  array  $arguments
     * @return mixed
     * @static
     */
    public static function corruptColumnArguments(
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
     * Missing Column Arguments
     *
     * @param  string  $class
     * @param  string  $called_function
     * @param  array  $missing_arguments
     * @param  array  $arguments
     * @return mixed
     * @static
     */
    public static function missingColumnArguments(
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

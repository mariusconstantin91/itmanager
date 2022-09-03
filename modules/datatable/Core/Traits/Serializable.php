<?php

namespace Modules\DataTable\Core\Traits;

use Illuminate\Support\Str;
use Laravel\SerializableClosure\SerializableClosure;
use ReflectionClass;

trait Serializable
{
    /**
     * Serialization
     *
     * @throws \Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException
     */
    public function __serialize(): array
    {
        SerializableClosure::setSecretKey(static::$serializationSecretKey);
        $reflect = new ReflectionClass($this);
        $props = $reflect->getProperties();

        $serialized = collect();

        foreach ($props as $prop) {
            if ($prop->getType() &&
                $prop->getType()->getName() === 'Closure' &&
                isset($this->{$prop->getName()})
            ) {
                $property = 'Closure_' . $prop->getName();
                $data = serialize(
                    new SerializableClosure($this->{$prop->getName()})
                );
            } elseif ($prop->getType() &&
                Str::contains($prop->getType()->getName(), [
                    'ColumnsCollection',
                    'ActionsCollection',
                    'FiltersCollection',
                ])
            ) {
                $property = $prop->getName();
                $data = $this->{$prop->getName()}->jsonSerialize();
            } elseif (isset($this->{$prop->getName()})) {
                $property = $prop->getName();
                $data = $this->{$prop->getName()};
            }

            if (isset($property) && isset($data)) {
                $serialized->put($property, $data);
            }
        }

        return $serialized->toArray();
    }

    /**
     * Unserialization
     *
     * @param  array  $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        SerializableClosure::setSecretKey(static::$serializationSecretKey);
        $reflect = new ReflectionClass($this);
        $props = $reflect->getProperties();

        foreach ($props as $prop) {
            if ($prop->getType() &&
                $prop->getType()->getName() === 'Closure' &&
                isset($data['Closure_' . $prop->getName()])
            ) {
                $this->{$prop->getName()} = unserialize(
                    $data['Closure_' . $prop->getName()]
                )->getClosure();
            } elseif ($prop->getType() &&
                Str::contains($prop->getType()->getName(), [
                    'ColumnsCollection',
                    'ActionsCollection',
                    'FiltersCollection',
                ])
            ) {
                $this->{$prop->getName()} = $prop
                    ->getType()
                    ->getName()
                    ::make($data[$prop->getName()]);
            } elseif (isset($data[$prop->getName()])) {
                $this->{$prop->getName()} = $data[$prop->getName()];
            }
        }
    }
}

<?php
declare (strict_types=1);

namespace App\Helper;

use InvalidArgumentException;

class ObjectHelper
{
    /**
     * Finds the getter methods for a given set of properties in a list of objects.
     *
     * @param object[] $objects    The list of objects to search for getter methods.
     * @param string[] $properties The list of properties to find getters for. If empty, all getters in the objects will be returned.
     * @return string[] An array of getter method names.
     * @throws InvalidArgumentException If the input is invalid or the class does not have the specified property.
     */
    public static function findGettersByProperties(array $objects, array $properties): array
    {
        $firstEntity = reset($objects);

        if (!is_object($firstEntity)) {
            throw new InvalidArgumentException(sprintf(
                "Expected an array of objects. %s given",
                ucfirst(gettype($firstEntity))
            ));
        }

        //If properties are not empty
        if (!empty($properties)) {
            $foundGetters = array_map(static function ($property) use ($firstEntity) {

                $get = 'get' . ucfirst($property);
                $is = 'is' . ucfirst($property);

                if (!property_exists($firstEntity, $property)) {
                    throw new InvalidArgumentException(sprintf(
                        "The '%s' class doesn't have a '%s' property.",
                        $firstEntity::class,
                        $property
                    ));
                }

                if (method_exists($firstEntity, $get)) {
                    return $get;
                }

                if (method_exists($firstEntity, $is)) {
                    return $is;
                }

                throw new InvalidArgumentException("Property '$property' of the '$fqn' doesn't have a 'is' or 'get' method.");

            }, $properties);
        } else {
            //If properties are empty get all class methods
            $methods = get_class_methods($firstEntity);
            $foundGetters = array_filter($methods, fn($getter) => str_starts_with($getter, 'get') || str_starts_with($getter, 'is'));
        }


        return $foundGetters;
    }

    public static function findGetterByProperty()
    {

    }
}
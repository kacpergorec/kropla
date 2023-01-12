<?php
declare (strict_types=1);

namespace App\Helper;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionObject;

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
    public static function findGettersByProperties(array $objects, array $properties = []): array
    {
        $firstEntity = reset($objects);

        if (!is_object($firstEntity)) {
            throw new InvalidArgumentException(sprintf(
                "Expected an array of objects. %s given",
                ucfirst(gettype($firstEntity))
            ));
        }

        if (empty($properties)) {
            $properties = self::findProperties($firstEntity, true);
        }

        $result = [];
        foreach ($properties as $property) {
            $methodName = "get" . ucfirst($property);
            if (method_exists($firstEntity, $methodName)) {
                $result[$property] = $methodName;
                continue;
            }
            $methodName = "is" . ucfirst($property);
            if (method_exists($firstEntity, $methodName)) {
                $result[$property] = $methodName;
            }
        }

        // return combined array of [property => getter] - properties as keys are used in the sorting.

        return $result;
    }

    public static function findProperties(object $object, bool $asAnArray = false)
    {
        $properties = (new ReflectionObject($object))->getProperties();
        if ($asAnArray) {
            $properties = array_map(function ($property) {
                return $property->getName();
            }, $properties);
        }
        return $properties;
    }


    public static function readableMethodString(string $string)
    {
        $beforeUppercaseLetter = '/(?<! )[A-Z]/';

        $result = preg_replace($beforeUppercaseLetter, ' $0', $string);
        $result = mb_strtolower($result);

        return ucfirst($result);
    }
}
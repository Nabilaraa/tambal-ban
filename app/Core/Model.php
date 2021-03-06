<?php

require_once __DIR__ . "/Helpers/Str.php";
require_once __DIR__ . "/Contracts/Model.php";

abstract class Model implements ModelImp
{
    /**
     * Convert associative array to model class.
     *
     * @param object $object
     * @return \Model
     */
    public static function serialize($object)
    {
        $model = new static();

        foreach ($object as $key => $value) {
            $camelCaseKey = Str::snakeToCamelCase($key);
            $model->{$camelCaseKey} = $value;
        }

        return $model;
    }

    /**
     * Convert many associative array to model class.
     *
     * @param array $objects
     * @return array
     */
    public static function serializeMany($objects)
    {
        $models = [];

        foreach ($objects as $object) {
            $model = self::serialize($object);
            array_push($models, $model);
        }

        return $models;
    }
}

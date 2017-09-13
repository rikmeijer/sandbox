<?php
/**
 * User: hameijer
 * Date: 13-9-17
 * Time: 14:25
 */

namespace transformers;

class Struct
{
    public function __construct()
    {
        $properties = get_object_vars($this);
        foreach (func_get_args() as $value) {
            $property = array_shift($properties);
            $this->$property = $value;
        }
    }

    public function __get($property)
    {
    }

    public function __set($property, $value)
    {
    }

}
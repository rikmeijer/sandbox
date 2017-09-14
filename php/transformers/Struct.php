<?php
/**
 * User: hameijer
 * Date: 13-9-17
 * Time: 14:25
 */

namespace transformers;

abstract class Struct
{
    public function __get(string $identifier) {
        return $this->$identifier;
    }
    public function __set(string $identifier, $value) {
        $this->map($identifier, $value);
    }
    abstract public function map(string $identifier, $value);
}
<?php
/**
 * User: hameijer
 * Date: 13-9-17
 * Time: 13:51
 */

namespace transformers;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Transformable.php';

class Person implements Transformable
{
    public function __construct(string $firstname, string $lastname)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    function transform(Transformer $transformer): Transformation
    {
        return $transformer->transform($this);
    }

    function fillStruct(Struct $struct): Struct
    {
        foreach (get_object_vars($struct) as $structPropertyIdentifier => $value) {
            switch ($structPropertyIdentifier) {
                case 'firstname':
                    $struct->firstname = $this->firstname;
                    break;
                case 'lastname':
                    $struct->lastname = $this->lastname;
                    break;
            }
        }
        return $struct;
    }
}
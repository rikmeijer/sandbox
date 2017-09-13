<?php
/**
 * User: hameijer
 * Date: 13-9-17
 * Time: 13:55
 */

namespace transformers;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Struct.php';


interface Transformable
{
    function transform(Transformer $transformer) : Transformation;
    function fillStruct(Struct $struct) : Struct;
}
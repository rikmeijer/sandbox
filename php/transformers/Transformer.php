<?php
/**
 * User: hameijer
 * Date: 13-9-17
 * Time: 13:51
 */

namespace transformers;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Transformation.php';


interface Transformer
{
    function transform(Transformable $transformable) : Transformation;
}
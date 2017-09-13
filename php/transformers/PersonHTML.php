<?php
/**
 * User: hameijer
 * Date: 13-9-17
 * Time: 13:52
 */

namespace transformers;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Struct.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Transformer.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PersonHTMLTransformation.php';

class PersonHTMLData extends Struct {
    public $firstname;
    public $lastname;
}

class PersonHTML implements Transformer
{

    function transform(Transformable $transformable): Transformation
    {
        return new PersonHTMLTransformation($transformable->fillStruct(new PersonHTMLData()));
    }


}
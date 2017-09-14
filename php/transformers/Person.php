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

    function transformTo(Struct $transformation): void
    {
        $transformation->map('firstname', $this->firstname);
        $transformation->map('lastname', $this->lastname);
    }
}
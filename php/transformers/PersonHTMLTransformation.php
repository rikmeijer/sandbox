<?php
/**
 * User: hameijer
 * Date: 13-9-17
 * Time: 14:05
 */

namespace transformers;
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Struct.php';


class PersonHTMLData extends Struct {
    protected $firstname;
    protected $lastname;

    public function map(string $identifier, $value) {
        $this->$identifier = $value;
    }
}

class PersonHTMLTransformation
{
    public function render(PersonHTMLData $data) {
        print '<div>' . $data->firstname . '<br />' . $data->lastname . '</div>';
    }

}
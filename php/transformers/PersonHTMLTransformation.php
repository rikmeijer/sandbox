<?php
/**
 * User: hameijer
 * Date: 13-9-17
 * Time: 14:05
 */

namespace transformers;
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Transformation.php';


class PersonHTMLTransformation implements Transformation
{
    /**
     * @var PersonHTMLData
     */
    private $data;

    public function __construct(PersonHTMLData $data)
    {
        $this->data = $data;
    }

    public function render() {
        print '<div>' . $this->data->firstname . '<br />' . $this->data->lastname . '</div>';
    }

}
<?php
namespace transformers;
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Person.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PersonHTMLTransformation.php';

$person = new Person("John", "Doo");
$htmldata = new PersonHTMLData();
$person->transformTo($htmldata);

$html = new PersonHTMLTransformation();
$html->render($htmldata);
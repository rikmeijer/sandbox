<?php
namespace transformers;
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Person.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'PersonHTML.php';

$person = new Person("John", "Doo");
$html = $person->transform(new PersonHTML());

print $html->render();
<?php

preg_match("/(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2})/", "yyyy-mm-dd", $matches);
var_dump($matches);


class Arr extends ArrayObject {
	
}
function foo(ArrayObject $array) {
	
}

$array = array("foo" => "banana", "boo" => "apple", "bar" => "orange");

var_dump($array);

$array += array("bar2" => "cherry");

var_dump($array);

//foo($array);
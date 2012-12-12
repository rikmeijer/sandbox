<?php

$array;
$array = array(
	"test" => &$array,
	"test2" => &$array
);

$array2 = $array;



function is_reference($a, $b) {
	return print_r($a, true) === print_r($b, true);
}
var_dump(is_reference($array, $array["test"]));
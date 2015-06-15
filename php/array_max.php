<?php

$array = array();

for ($i = 0; $i < 450000; $i++) {
	$string = str_pad('', 50, 'a');
	$array[$string] = $string;
}

var_dump(memory_get_usage(true));
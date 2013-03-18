<?php

$a = array();
$c = 'A';
for ($i = 0; $i < 114; $i++) {
	$a[] = "'$c' => array('string', array())";
	$c++;
}


print 'array(';
print PHP_EOL . "    " . join("," . PHP_EOL . "    ", $a);
print PHP_EOL . ');';
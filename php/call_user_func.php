<?php
header('Content-Type: text/plain');

$callback = function(&$i) { 
	print PHP_EOL . "Hello World!"; $i++; 
};

function callback(&$a) {
	$a++;
}

$i = 0;
$callback($i);
print PHP_EOL . $i;

$a = 0;
call_user_func_array('callback', array(&$a));
print PHP_EOL . $a;
call_user_func_array('callback', array(&$a));
print PHP_EOL . $a;

call_user_func((function() use (&$a) {
	print PHP_EOL . $a++;
}));
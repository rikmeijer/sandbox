<?php

function test0(&$a = null, &$b = null, $c = null)
{
	$a = 'a';
	$b = 'b';
	print $c;
	
}
test0($a, $b, $a.$b);


function test(&$a = 1, &$b = "a", &$c = array("value" => 0))
{
	var_dump($a, $b, $c);
}

test($a, $b, $c);
var_dump($c);

function foobar($a, $b) {
	var_dump(func_get_args());
}

$e_a = 0;
$e_b = 0;

foobar(
	call_user_func(function($e_a) use (&$e_b) {
		$e_b++;
		return $e_a;
	}, $e_a),
	$e_b
);

class foo
{
	function bar(array $arr, $bla, $bil) {
		
	}
}

$foo = new foo();
$foo->bar(array("Hello World"));

function params(array $aar) {
	
}
params("Hello World");

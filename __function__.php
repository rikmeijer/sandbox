<?php

//namespace test {
	class foo {
		function bar(array $array) {
			var_dump(__FUNCTION__, __METHOD__);
		}
	}
	function test(array $array) {
		var_dump(__FUNCTION__, __METHOD__);
	}
	$test = function(array $array) {
		var_dump(__FUNCTION__, __METHOD__);
	};
	
	$foo = new foo();
	echo '<br />foo::bar(): ' . $foo->bar(array());
	echo '<br />foo::bar(): ' . foo::bar(array());
	echo '<br />test(): ' . test(array());
	echo '<br />$test(): ' . $test(array());
//}


var_dump(call_user_func($func = function($param1) use (&$func)
{

//some code here
if ($param1 === 0) {
	return true;
} else {
	return $func($param1 - 1);
}
//some code here

}, 10));

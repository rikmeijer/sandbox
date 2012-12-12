<?php

class Foo {
	
	static $what = "World";
	
	static function Bar($what) {
		echo " - Hello $what";
	}
}


$class = 'Foo';
$method = 'Bar';

$class::$method($class::${"what"});
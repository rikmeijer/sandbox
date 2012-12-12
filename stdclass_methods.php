<?php

$class = (object) array(
	"foo" => function($where) {
		return "Hello $where!";
	}
);
var_Dump($class);
print $class->foo("World");
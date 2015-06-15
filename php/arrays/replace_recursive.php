<?php

$array1 = array('foo' => 'bar');
$array2 = array('foo' => null);

var_Dump(
        array_replace_recursive($array2, $array1),
        array_replace_recursive($array1, $array2)
);

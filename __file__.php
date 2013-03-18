<?php

function test($var = __FILE__, $line = __LINE__) {
	echo $var . '(' . $line . ')';
}

test();

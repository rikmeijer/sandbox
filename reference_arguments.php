<?php
function foo(array &$bar = null) {
	$bar[] = "fubar";
}

// $boo = ""; // Causes fatal error (as expected)
foo($boo);
print_r($boo);
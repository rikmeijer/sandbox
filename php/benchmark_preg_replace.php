<?php

$subject = 'H.L.W.M.';


$start1 = microtime(true);
for ($i = 0; $i < 1000000; $i++) {
	$result = preg_replace('/[a-z]+/i', '', $subject);
}
print '<br />done: ' . round(microtime(true) - $start1, 3) . 'ms';


$start2 = microtime(true);
for ($i = 0; $i < 1000000; $i++) {
	$result = preg_replace('/[a-z]/i', '', $subject);
}
print '<br />done: ' . round(microtime(true) - $start2, 3) . 'ms';

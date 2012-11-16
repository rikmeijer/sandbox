<?php

header('Content-Type: text/plain');

$array = array(
	'cherry' => array(
		'human-name' => 'Kers',
		'order' => 1
	),
	'apple' => array(
		'human-name' => 'Appel',
		'order' => 0
	),
	'banana' => array(
		'human-name' => 'Banaan',
		'order' => 1
	),
	'durian' => array(
		'human-name' => 'Durian',
		'order' => 0
	)
);

print_r($array);

uasort($array, function($fruit_a, $fruit_b) {
	$order_comparison = strcasecmp($fruit_a['order'], $fruit_b['order']);
	if ($order_comparison !== 0) {
		return $order_comparison;
	}
	
	return strcasecmp($fruit_a['human-name'], $fruit_b['human-name']);
});

print_r($array);
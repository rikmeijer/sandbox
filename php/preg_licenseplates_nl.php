<?php

$formats = array(
	'XX-99-99' => 'XX-99-99',
	'XX9999' => 'XX-99-99',
	'99-99-XX' => '99-99-XX',
	'9999XX' => '99-99-XX',
	'99-XX-99' => '99-XX-99',
	'99XX99' => '99-XX-99',
	
	'XX-99-XX' => 'XX-99-XX',
	'XX99XX' => 'XX-99-XX',
	'XX-XX-99' => 'XX-XX-99',
	'XXXX99' => 'XX-XX-99',
	'99-XX-XX' => '99-XX-XX',
	'99XXXX' => '99-XX-XX',
	
	'99-XXX-9' => '99-XXX-9',
	'99XXX9' => '99-XXX-9',
	'9-XXX-99' => '9-XXX-99',
	'9XXX99' => '9-XXX-99',
	
	'XX-999-X' => 'XX-999-X',
	'XX999X' => 'XX-999-X',
	'X-999-XX' => 'X-999-XX',
	'X999XX' => 'X-999-XX',
	
	'71fzjs' => '71-FZ-JS'
);

function isLicensePlate($string) {
	return preg_match('/^([A-Z]{2}-?\d{2}-?\d{2}|\d{2}-?\d{2}-?[A-Z]{2}|\d{2}-?[A-Z]{2}-?\d{2}|[A-Z]{2}-?\d{2}-?[A-Z]{2}|[A-Z]{2}-?[A-Z]{2}-?\d{2}|\d{2}-?[A-Z]{2}-?[A-Z]{2}|\d{2}-?[A-Z]{3}-?\d|\d-?[A-Z]{3}-?\d{2}|[A-Z]-?\d{3}-?[A-Z]{2}|[A-Z]{2}-?\d{3}-?[A-Z])/i', $string) === 1;
} 

foreach ($formats as $format_identifier => $format_expected) {
	
	var_Dump($format_identifier . ': ' . (isLicensePlate($format_identifier) ? 'j' : 'n'));
	
}
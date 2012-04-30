<?php

set_time_limit(0);

function benchmark($times, $function, array $parameters) {
	$start = microtime(true);
	for ($i = 0; $i < $times; $i++) {
		call_user_func_array($function, $parameters);
	}
	return microtime(true) - $start;
}

$array = array("inactief" => array(0 => "valid", 1 => array()), "geslacht" => array(0 => "valid", 1 => array()), "titel_voor" => array(0 => "valid", 1 => array()), "titel_na" => array(0 => "valid", 1 => array()), "voorletters" => array(0 => "valid", 1 => array()), "voornamen" => array(0 => "valid", 1 => array()), "roepnaam" => array(0 => "valid", 1 => array()), "tussenvoegsel" => array(0 => "valid", 1 => array()), "achternaam" => array(0 => "valid", 1 => array()), "website" => array(0 => "valid", 1 => array()), "geboortedatum" => array(0 => "valid", 1 => array()), "geboorteplaats" => array(0 => "valid", 1 => array()), "geboorteland" => array(0 => "valid", 1 => array()), "adressen" => array(0 => "valid", 1 => array()), "email" => array(0 => "valid", 1 => array()), "telefoon" => array(0 => "valid", 1 => array()), "bank_nummer" => array(0 => "valid", 1 => array()), "bank_naam" => array(0 => "valid", 1 => array()), "bank_iban" => array(0 => "valid", 1 => array()), "bank_bic" => array(0 => "valid", 1 => array()), "bsn" => array(0 => "valid", 1 => array()), "opmerking" => array(0 => "valid", 1 => array()), "kenmerken" => array(0 => "valid", 1 => array()), "_users_id" => array(0 => "valid", 1 => array()), "dienstverbanden" => array(0 => "valid", 1 => array()));

print "<br />var_export: " . benchmark(100000, 'var_export', array($array, true)) . 'msec';
print "<br />print_r: " . benchmark(100000, 'print_r', array($array, true)) . 'msec';
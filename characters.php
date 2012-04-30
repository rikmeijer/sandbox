<?php

$string = '{"query":"SELECT\r\n										rel_persoon.achternaam AS `achternaam`,persoon_adressen_rel_persoon_adres_soorten_x.voorkeur AS `woonplaats_voorkeur`,persoon_adressen_rel_persoon_adres_soorten_x.plaats AS `woonplaats`\r\n									FROM rel_persoon\nLEFT JOIN  (persoon_adressen AS persoon_adressen_rel_persoon_adres_soorten_x INNER JOIN  rel_persoon_adres_soorten AS persoon_adressen_rel_persoon_adres_soorten ON (persoon_adressen_rel_persoon_adres_soorten_x.rel_persoon_adres_soorten_id = persoon_adressen_rel_persoon_adres_soorten._id)) ON (persoon_adressen_rel_persoon_adres_soorten_x.rel_persoon_id = rel_persoon._id AND persoon_adressen_rel_persoon_adres_soorten_x.voorkeur = \'ja\') \r\n									"}';
$string = str_replace("	", '\t', $string);

var_dump(json_decode($string, true));

for ($i = 0; $i < strlen($string); $i++) {
	
}

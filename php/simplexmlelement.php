<?php
$xml = <<<EOF
<RELATIES>
<RELATIE>
                <PK>NAWBES_00044069</PK>
                <L NR="1" OMS="Relatienummer" DISPLAY="44069">44069</L>
                <POLISSEN></POLISSEN>
            </RELATIE>
        </RELATIES>
EOF;

$elem = new SimpleXMLElement($xml);

foreach ($elem as $person) {
    printf("%s has got %d children.\n", $person['name'], $person->count());
    var_Dump($person->POLISSEN->children()->count());
}
?>
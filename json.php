<?php
var_dump(json_decode('{"key": null}', true));



$constants = get_defined_constants(true);
$json_errors = array();
foreach ($constants["json"] as $name => $value) {
    if (!strncmp($name, "JSON_ERROR_", 11)) {
        $json_errors[$value] = $name;
    }
}

var_Dump(json_decode('{"last-revision":["yes",{}],"entity-identifier":"test3_bedrijven","object-identifier":10,"action-time":1318231700,"action":["added",{"changes":"{"naam":"C4 Software"}"}]}', true));

var_Dump($json_errors[json_last_error()]);


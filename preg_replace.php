<?php

$string = 'IBAN0373222890';
do {
    $string = preg_replace("/(^0+|[^0-9]+)/", "", $string, -1, $count);
} while ($count > 0);

echo $string;
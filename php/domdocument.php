<?php

$test_document = new DOMDocument("1.0", "UTF-16");
//$test_document->appendChild($test_document->createElement("test-root"));
$test_document->load(__DIR__ . "/utf16.xml");

$test_document->encoding = 'UTF-8';
header("content-type: text/xml; charset=" . $test_document->encoding);
echo($test_document->saveXML());
//echo(mb_convert_encoding($test_document->saveXML($test_document->firstChild), 'UTF-8'));
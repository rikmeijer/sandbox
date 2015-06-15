<?php
$xml = new DOMDocument();
$xml->load(__DIR__ . '/wrapper.xml');
            
$xml->xinclude();
print_R(simplexml_import_dom($xml));
<?php

header("Content-Type: text/plain");
$filename = "C:/Users/Public/Documents/Virtual Machines/Windows XP Professional (RIO).zip";
$zip = new ZipArchive();


if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
}

//$zip->addFromString("testfilephp.txt" . time(), "#1 This is a test string added as testfilephp.txt.\n");
//$zip->addFromString("testfilephp2.txt" . time(), "#2 This is a test string added as testfilephp2.txt.\n");
//$zip->addFile($thisdir . "/too.php","/testfromfile.php");
echo "numfiles: " . $zip->numFiles . "\n";
echo "status:" . $zip->status . "\n";

var_dump($zip->statIndex(0));

$zip->close();
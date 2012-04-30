<?php
ob_get_clean();

ob_start();
$handle = fopen("php://output", "wb");
fwrite($handle, "Hello World");
fclose($handle);
$buffer = ob_get_clean();

header("Content-Length: " . strlen($buffer));
header("X-Content-Length: " . strlen($buffer));
print $buffer;
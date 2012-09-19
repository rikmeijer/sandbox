<?php


$included_file = __DIR__ . '/closure_extractor.php';

xdebug_start_code_coverage();

ob_start();
@include $included_file;
ob_end_clean();

$code_coverage = xdebug_get_code_coverage();

xdebug_stop_code_coverage();

$included_lines = file($included_file);

header('Content-Type: text/html');
print '<strong>' . $included_file . '</strong>';
print '<ol style="width: 1024px; margin: 0 auto;">';
foreach ($included_lines as $line_number => $included_line) {
	if (isset($code_coverage[$included_file][$line_number+1])) {
		print '<li style="background-color: #afa; font-family: monospace;">' . str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $included_line) . '</li>';
	} else {
		print '<li style="background-color: #faa; font-family: monospace;">' . str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $included_line) . '</li>';
	}
}
print '</ol>';
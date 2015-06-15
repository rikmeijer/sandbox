<?php
header("content-type: text/plain");

$a = $b = $c;

$closure = function ($foo, $bar) use ($a, $b, &$c) {
	// some code here
};


function getClosureCode($closure) {
	$reflection = new ReflectionFunction($closure);
	if ($reflection->isClosure() === false) {
		return false;
	}
	
	$file = file($reflection->getFileName());
	array_unshift($file, "");
	
	$function_buffer = '';
	foreach (array_slice($file, $reflection->getStartLine(), ($reflection->getEndLine() - $reflection->getStartLine() + 1), true)  as $line_identifier => $line) {
		if ($line_identifier === $reflection->getStartLine()) {
			$function_buffer .= substr($line, stripos($line, "function"));
			
		} elseif ($line_identifier < $reflection->getEndLine()) {
			$function_buffer .= $line;
			
		} elseif (false !== ($position_closing_curly_brace = strripos($line, "};"))) { // when declared in a statement
			$function_buffer .= substr($line, 0, $position_closing_curly_brace) . "}";
			
		} elseif (false !== ($position_closing_curly_brace = strripos($line, "},"))) { // when declared in an array
			$function_buffer .= substr($line, 0, $position_closing_curly_brace) . "}";
			
		} elseif (false !== ($position_closing_curly_brace = strripos($line, "}"))) { // fallback
			$function_buffer .= substr($line, 0, $position_closing_curly_brace) . "}";
			
		} else {
			return false; // unable to determine ending position
		}
	}
	
	return array(
		"static-variables" => array_keys($reflection->getStaticVariables()),
		"code" => $function_buffer
	);
}

print_r(getClosureCode($closure));
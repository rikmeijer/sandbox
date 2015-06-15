<?php
function sanitize_parameters(array &$parameters)
{
	foreach ($parameters as &$parameter_value) {
		if (is_array($parameter_value)) {
			if (!isset($parameter_value[0])) {
				
			} elseif ($parameter_value[0] === '') {
				unset($parameter_value[0]);
			}
			sanitize_parameters($parameter_value);
			
		} elseif (!is_numeric($parameter_value)) {
			// leave string
		} elseif (strpos($parameter_value, ".") !== false) {
			$parameter_value = (float)$parameter_value;
		} else {
			$parameter_value = (int)$parameter_value;
		}
	}
}
sanitize_parameters($_GET);
var_dump($_GET);
<?php

$array = array(	
	"recursion" => &$array
);

function pretty_json(array &$array) {
	if (empty($array)) {
		$array_identifier = 'array()';

	} elseif (!isset($array['___recursor'])) {
		$array['___recursor'] = array(
			'used' => false, // init with no recursion
			'variable-identifier' => '$arr_' . uniqid()
		);

		$array_generated = array();
		foreach ($array as $key => &$value) {
			if ($key !== '___recursor') {
				$array_generated[] = $key . ' => ' . pretty_json($value);
			}
		}

		if ($array['___recursor']['used'] === false) {
			// no recursion
			$array_identifier = 'array(' . join(', ', $array_generated) . ')';
		} else {
			// recursion
			$array_identifier = $array['___recursor']['variable-identifier'] . ' = array(' . join(', ', $array_generated) . ')';
		}

		unset($array['___recursor']); // cleanup
	} else { // recursion
		$recursor_used = &$array['___recursor']['used'];
		$recursor_used = true; // set recursion
		$array_generated = array();
		foreach ($array as $key => $value) {
			if ($key !== '___recursor') {
				$array_generated[] = $key . ' => &' . $array['___recursor']['variable-identifier'];
			}
		}
		$array_identifier = 'array(' . join(', ', $array_generated) . ')';
	}

	return $array_identifier;
}

print pretty_json($array);
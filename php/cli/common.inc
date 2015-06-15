<?php

function create_progressor($label, $total_progress) {
	return function($description) use ($label, $total_progress) {
		static $progress_bar_output_length, $current;

		if (!isset($progress_bar_output_length)) {
			echo "\n$label\n";
		} elseif (!isset($current)) {
			$current = 0;
		}
		
		$current++;
		
		$output = "|";
		$percentage = round($current / $total_progress * 100);
		for ($place = 0; $place <= 10; $place++) {
			if ($place <= ($percentage / 10)) { // devide by 4 because of progress bar width (25)
				$output .= "*";
			} else {
				$output .= " ";
			}
		}

		if ($percentage === 100) {
			$description = "done";
		}
		$output .= "| " . str_pad($percentage, 3, " ", STR_PAD_LEFT) . "/100%: " . str_pad(substr($description, 0, 25), 25, " ", STR_PAD_RIGHT);

		$progress_bar_output_length = fwrite(STDOUT, "\r" . $output);
	};
};

function line($message) {
	fwrite(STDOUT, PHP_EOL . $message);
}

function error($message) {
	fwrite(STDERR, PHP_EOL . $message);
	exit;
}

function input_string($message)
{
	line($message);
	return trim(fgets(STDIN));
}
function input_integer($message)
{
	line($message);
	$input = trim(fgets(STDIN));

	return is_numeric($input) ? (int) $input : null;
}

function input_choice($message, $default, array $choices) {
	line($message);
	foreach ($choices as $choice_identifier => $choice_label) {
		line(str_pad($choice_identifier, 3, ' ', STR_PAD_LEFT) . ') ' . $choice_label);
	}	
	if (!isset($default)) {
		$input = input_integer('#');
	} else {
		$input = input_integer('[' . $default . ']#');
	}
	
	if (!isset($choices[$input])) {
		line('invalid choice');
		return input_choice($message, $default, $choices);
	}
	return $choices[$input];
}

function input_model($message, array $properties) {
	line($message);
	
	$input = array();
	foreach ($properties as $property_identifier => $property) {
		// found
		switch ($property[0]) {
			case "string":
				$input[$property_identifier] = input_string($property_identifier . ': ');
				break;

			case "integer":
				$input[$property_identifier] = input_integer($property_identifier . ': ');
				break;

			case "object":
				$input[$property_identifier] = array();
				$choice = input_choice('Object ' . $property_identifier . ', please select action', 0, array(
					'add',
					'skip'
				));
				while ($choice === 'add') {
					$identifier = input_string('Enter identifier: ');
					$input[$property_identifier][$identifier] = input_model($property_identifier . ': ', $property[1]);
					
					$choice = input_choice('Object ' . $property_identifier . ', please select action', 0, array(
						'add',
						'done'
					));
				}
				break;

			case "array":
				$input[$property_identifier] = array();
				$choice = input_choice('Array ' . $property_identifier . ', please select action', 0, array(
					'add',
					'skip'
				));
				while ($choice === 'add') {
					$input[$property_identifier][] = input_model($property_identifier . ': ', $property[1]);
					
					$choice = input_choice('Object ' . $property_identifier . ', please select action', 0, array(
						'add',
						'done'
					));
				}
				break;

			case "state" :
				$choices = array();
				foreach ($property[1] as $state_identifier => $state) {
					$choices[] = $state_identifier;
				}
				
				$state_identifier_chosen = input_choice($property_identifier . ': ', null, $choices);
				$input[$property_identifier] = array($state_identifier_chosen, input_model('State ' . $state_identifier_chosen, $property[1][$state_identifier_chosen]));
				break;

			case "callback":
				line('callbacks are not supported');
				continue;

			case "schema":
				line('schemas are not supported');
				break;

			case "model":
				$input[$property_identifier] = input_model('Model ' . $property_identifier . ': ', $property[1]);
				break;

			default:
				error($property_identifier . ' is of unknown type ' . $property[0]);
		}
	}
	return $input;
}

function ask_configuration($config_directory)
{
	$config_directory_handle = opendir($config_directory);
	if ($config_directory_handle === false) {
		return false;
	}
	
	$configurations = array();
	while (($file = readdir($config_directory_handle)) !== false) {
		if (substr($file, 0, 1) === '.') {
			continue;
		} elseif (is_file($config_directory . '/'. $file)) {
			$configurations[] = basename($file, '.inc');
		}
	}
	
	return input_choice('Kies een configuratie:', null, $configurations);
}
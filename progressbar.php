<?php

function progressBar($current, $total, $label = null)
{
	static $progress_bar_output_length;
	
	if (isset($label)) {
		echo $label . " |";
		unset($progress_bar_output_length);
	} else {
		for ($place = $progress_bar_output_length; $place > 0; $place--) {
			echo "\010"; // use backspaces to remove previous progressbar
		}
	}

	$output = '';
	$percentage = ($current / $total * 100);
	for ($place = 0; $place <= 100; $place++) {
		if ($place <= $percentage) {
			$output .= "*";
		} else {
			$output .= " ";
		}
	}
	
	$output .= "| " . str_pad($percentage, 3, ' ', STR_PAD_LEFT) . "/100%"; // end the bar with a nice edge and a label

	if ($current == $total) {
		$output .= "\n";
	}
	
	$progress_bar_output_length = fwrite(STDOUT, $output);
}

progressBar(0, 100, 'executing queries');
sleep(1);
progressBar(25, 100, 'executing queries');
sleep(1);
progressBar(50, 100, 'executing queries');
sleep(1);
progressBar(75, 100, 'executing queries');
sleep(1);
progressBar(100, 100, 'executing queries');
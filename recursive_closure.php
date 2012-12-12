<?php

$func = function ($max_level) {
	if ($max_level === 0) {
		return true;
	} else {
		var_Dump(__FUNCTION__);
		call_user_func(__FUNCTION__, $max_level-1);
	}
};

$func(10);
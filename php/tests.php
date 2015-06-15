<?php
abstract class base {
	
	abstract static function func();
	
}

class type {
	static function func() {
	echo "FFF";
	}
}

type::func();
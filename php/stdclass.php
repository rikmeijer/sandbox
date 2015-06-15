<?php

$array = array(
	"property" => "Foo",
	"functie" => function($parameter) {
		return $this->property . " " . $parameter;
	}
);

$object = (object) $array;
print call_user_func($object->functie, "Bar");

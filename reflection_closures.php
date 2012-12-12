<?php

$closure = function($foo) {};

$reflection = new Reflection($closure);

var_dump(ReflectionFunction::export($closure, true));
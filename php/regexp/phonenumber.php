<?php

$value = '+331566.336.33';

var_dump(preg_match('/^\+?\d{2,}+$/', $value));

var_dump(preg_replace('/^(\+)?(\d{2,}+)$/', '$1$2', $value));


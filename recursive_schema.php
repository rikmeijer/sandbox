<?php
$schema_schema;
$schema_schema = array("properties" => array(
	"type" => array("object", array(
		"type" => array(
			"type" => array("state", array(
				"states" => array(
					"type" => array("object", array(
						"properties" => array(
							"type" => &$schema_schema
						)
					))
				)
			))
		)
	))
));

print_r($schema_schema);
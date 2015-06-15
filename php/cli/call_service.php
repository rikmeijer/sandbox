<?php
define('CONFIGURATION_DIRECTORY', __DIR__ . '/../config');
require_once __DIR__ . '/common.inc';

$configuration = ask_configuration(CONFIGURATION_DIRECTORY);
if ($configuration === false) {
	error('configuration directory invalid?' . CONFIGURATION_DIRECTORY);
	
} elseif (!file_exists(CONFIGURATION_DIRECTORY . '/' . $configuration . '.inc')) {
	error('no configuration found for ' . $configuration);
	
}

function call_service($token, $engine) {
	$path = input_string("Please enter service: ");

	$resolved_path = $engine->resolveResourcePath($path);

	$call = reset($resolved_path);

	$storage = $engine->get_storage($call['storage-identifier']);
	$entity = $storage->getEntityInstance($call['entity-identifier']);
	$actions = $entity->getActions();
	$action = $actions[$call['service']];

	$parameters = input_model('Parameters:', $action['parameters']);
	switch ($action['method'][0]) {
		case "post":
			switch (input_choice('Select payload-source: ', null, array('file', 'manual'))) {
				case 'file':
					$working_dir = getcwd();
					$payload_filename = realpath(input_string('Enter filename [' . $working_dir . ']: '));
					$in = fopen($payload_filename, 'r');

					break;

				case 'manual':
					$in = tmpfile();
					fwrite($in, json_encode(input_model('Payload: ', $action['method'][1]['payload'])));
					rewind($in);
					break;
			}
			break;

		case "get":
			$in = tmpfile();
			break;
	}

	try {
		$engine->handleRequest($token, $path, $parameters, $in, STDOUT);
	} catch (Exception $e) {
		line($e->getMessage());
	}
	
	// restart
	call_service($token, $engine);
}

require __DIR__ . "/../engine/bootstrap.inc";
$engine = require CONFIGURATION_DIRECTORY . '/' . $configuration . '.inc';

// authenticate first
$errors = array();
$token_anonymous = $engine->authentication()->authenticate_anonymous($errors);
if ($token_anonymous === false) {
	error('failed logging in anonymously: ' . print_r($errors, true));
}

$username = input_string("Enter username: ");
$password = input_string("Enter password: ");

$authentication_errors = array();
$token = $engine->authentication()->authenticate($token_anonymous, $username, $password, $authentication_errors);
if ($token === false) {
	error('failed logging in: ' . print_r($authentication_errors, true));
}
line('Using token ' . $token);

call_service($token, $engine);
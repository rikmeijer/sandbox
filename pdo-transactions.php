<?php

$pdo = new PDO("mysql:host=localhost", "root", "root");
$autocommit_statement = $pdo->query("SELECT @@autocommit");
if ($autocommit_statement === false) {
	var_dump($pdo->errorInfo());
}
var_dump($autocommit_statement->fetch());

$pdo->query("START TRANSACTION");

$autocommit_statement = $pdo->query("SELECT @@autocommit");
var_dump($autocommit_statement->fetch());

sleep(5);

$pdo->query("COMMIT");
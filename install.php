<?php

/**
 * Open a connection via PDO to create a
 * new database and table with structure.
 *
 */
$file = '../data/init.sql';
require "config.php";


if (!is_file($file)){
	echo 'File not found!';
	die;
} elseif(!is_readable($file)){
    header("{$_SERVER['SERVER_PROTOCOL']} 403 Forbidden");
    header("Status: 403 Forbidden");
    echo 'File not accessible!';
    die;

} else {
	echo 'File found and accessible!';
}

try  {
	
	$connection = new PDO("mysql:host=$host", $username, $password, $options);
	$sql = file_get_contents($file);
	$connection->exec($sql);
	
	echo "Database and table users created successfully.";
	
} catch(PDOException $error) {
	
	echo $sql . "<br>" . $error->getMessage();
}
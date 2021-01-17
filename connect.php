<?php

$config = require_once 'database_config.php'; //Dodanie odpowiedniego pliku

try {
	//Nawiązanie połączenia z bazą danych
	$connection = new PDO('mysql:host='.$config['host'].';dbname='.$config['database'].';charset=utf8', $config['user'], $config['password'], [
		PDO::ATTR_EMULATE_PREPARES => false, 
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	]);
	
} catch (PDOException $error) { //Sprawdzenie, czy wystąpiły jakieś błędy
	
	echo $error->getMessage();
	exit('Database error');
	
}


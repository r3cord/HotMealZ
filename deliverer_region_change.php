<?php

session_start();

if(isset($_SESSION['logged_id_admin']))
{
	if(!isset($_POST['deliverer_id']))
	{
		header('Location: deliverers_management.php');
		exit();
	}
}
else
{
	header('Location: index.php');
	exit();
}

//połączenie z bazą danych
require_once 'connect.php';

//zmiana regionu dostawcy w bazie danych
$query = $connection->query('UPDATE deliverers SET id_region = "'.$_POST['region_id'].'" WHERE id LIKE "'.$_POST['deliverer_id'].'"');

//zapisanie w zmiennej sesyjnej komunikatu dla admina
$_SESSION['deliverers_message'] = "Zmieniono region dostawcy ".$_POST['firstname']." ".$_POST['secondname'];
	
header('Location: deliverers_management.php');
exit();
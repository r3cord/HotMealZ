<?php
session_start();

if(isset($_SESSION['logged_id_partner']))
{
	if(isset($_GET['id']))
	{
		//połączenie się z bazą danych
		require_once 'connect.php';
		//usunięcie dania o id przesłanym w funkcji $_GET['id'] z bazy danych
		$connection->query('DELETE FROM dishes WHERE id LIKE '.$_GET['id']);
		header('Location: restaurant_offer_changeform.php');
		exit();
	}
	else
	{
		header('Location: restaurant_offer_changeform.php');
		exit();
	}
}
else
{
	header('Location: index.php');
	exit();
}
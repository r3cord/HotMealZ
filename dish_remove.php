<?php
session_start();

if(isset($_SESSION['logged_id_partner']))
{
	if(isset($_GET['id']))
	{
		//połączenie się z bazą danych
		require_once 'connect.php';
		//usunięcie dania o id przesłanym w zmiennej $_GET['id'] z bazy danych
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
else if(isset($_SESSION['logged_id_admin']))
{
	if(isset($_GET['id']))
	{
		//połączenie się z bazą danych
		require_once 'connect.php';
		//usunięcie dania o id przesłanym w zmiennej $_GET['id'] z bazy danych
		$connection->query('DELETE FROM dishes WHERE id LIKE '.$_GET['id']);
		
		//ustawienie zmiennej sesyjnej potrzebnej do przeniesienia admina do oferty odpowiednej restauracji
		$_SESSION['restaurant_id'] = $_GET['restaurant_id'];
		header('Location: admin_restaurant_offer_changeform.php');
		exit();
	}
	else
	{
		header('Location: offer_management.php');
		exit();
	}
}
else
{
	header('Location: index.php');
	exit();
}
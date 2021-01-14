<?php
session_start();

if(isset($_SESSION['logged_id_partner']) && isset($_GET['id']))
{
	//połączenie się z bazą danych
	require_once 'connect.php';
	//zmiana statusu dania na "w trakcie dostawy"
	$connection->query('UPDATE orders SET status = "w trakcie dostawy" WHERE id LIKE "'.$_GET['id'].'"');
	header('Location: index.php');
	exit();
}
else
{
	header('Location: index.php');
	exit();
}
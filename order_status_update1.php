<?php
session_start();

if(isset($_SESSION['logged_id_partner']) && isset($_GET['order_id']))
{
	//połączenie się z bazą danych
	require_once 'connect.php';
	//zmiana statusu dania na "oczekujące"
	$connection->query('UPDATE orders SET status = "oczekujące" WHERE id LIKE "'.$_GET['order_id'].'"');
	header('Location: index.php');
	exit();
}
else
{
	header('Location: index.php');
	exit();
}
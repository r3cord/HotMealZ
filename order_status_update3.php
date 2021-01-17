<?php
session_start();

if(isset($_SESSION['logged_id_deliverer']) && isset($_GET['id']))
{
	//połączenie się z bazą danych
	require_once 'connect.php';
	//pobranie do zmiennej aktualnej daty (w celu wpisania do bazy danych daty dostarczenia)
	$time=date('Y-m-d H:i:s');
	//zmiana statusu dania na "w trakcie dostawy"
	$connection->query('UPDATE orders SET status = "dostarczone", delivery_date = "'.$time.'" WHERE id LIKE "'.$_GET['id'].'"');
	header('Location: index.php');
	exit();
}
else
{
	header('Location: index.php');
	exit();
}
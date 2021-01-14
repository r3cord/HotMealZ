<?php
session_start();

if(isset($_SESSION['logged_id_partner']) && isset($_GET['order_id']))
{
	//połączenie się z bazą danych
	require_once 'connect.php';
	
	//pobranie z bazy danych informacji o dostawcach z regionu, w którym jest restauracja wykonująca zamówienie o zmienianym statusie w celu policzenia, który dostawca ma najmniej aktualnych zamówień (ten dostanie nowe zamówienie)
	$deliverersQuery = $connection->query('SELECT * FROM deliverers WHERE id_region LIKE "'.$_GET['region_id'].'"');
	$deliverers = $deliverersQuery->fetchAll();
	
	//znalezienie dostawcy z najmniejszą liczbą aktualnych zamówień
	$min = 99999;
	$min_id = -1;
	foreach ($deliverers as $del)
	{
		$delQuery = $connection->query('SELECT id FROM orders WHERE id_deliverer LIKE "'.$del['id'].'" AND (status LIKE "w trakcie dostawy" OR status LIKE "oczekujące")');
		$a = $delQuery->rowCount();
		if ($a < $min) 
		{
			$min = $a;
			$min_id = $del['id'];
		}
	}
	
	//uaktualnienie statusu dania oraz przydzielenie mu dostawcy
	$connection->query('UPDATE orders SET status = "oczekujące", id_deliverer = "'.$min_id.'" WHERE id LIKE "'.$_GET['order_id'].'"');
	header('Location: index.php');
	exit();
}
else
{
	header('Location: index.php');
	exit();
}
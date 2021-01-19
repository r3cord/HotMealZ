<?php
session_start();

if(isset($_SESSION['logged_id_admin']))
{
	if(isset($_GET['partner_id']))
	{
		//połączenie się z bazą danych
		require_once 'connect.php';
		
		//pobranie identyfikatorów potrzebnych do usunięcia danych związanych z partnerem w innych tabelach bazy danych - list dań do zamówień, zamówień, reklamacji i dań
		$restaurantsQuery = $connection->query('SELECT id FROM restaurants WHERE id_partner LIKE "'.$_GET['partner_id'].'"');
		$restaurants = $restaurantsQuery->fetchAll();
		foreach ($restaurants as $restaurant)
		{
			$ordersQuery = $connection->query('SELECT id FROM orders WHERE id_restaurant LIKE "'.$restaurant['id'].'"');
			$orders = $ordersQuery->fetchAll();
			foreach ($orders as $order)
			{
				//usunięcie listy dań do zamówienia
				$odQuery = $connection->query('DELETE FROM od_connections WHERE id_order LIKE "'.$order['id'].'"');
				//usunięcie reklamacji do zamówienia
				$reclamationQuery = $connection->query('DELETE FROM reclamations WHERE id_order LIKE "'.$order['id'].'"');
			}
			//usunięcie zamówień wykonanych z danej restauracji
			$ordersQuery_nd = $connection->query('DELETE FROM orders WHERE id_restaurant LIKE "'.$restaurant['id'].'"');
			//usunięcie dań danej restauracji
			$dishesQuery = $connection->query('DELETE FROM dishes WHERE id_restaurant LIKE "'.$restaurant['id'].'"');
		}
		//usunięcie restauracji partnera
		$restaurantsQuery_nd = $connection->query('DELETE FROM restaurants WHERE id_partner LIKE "'.$_GET['partner_id'].'"');
		//usunięcie rekordu z kontem partnera
		$partnerQuery = $connection->query('DELETE FROM partners WHERE id LIKE "'.$_GET['partner_id'].'"');
		
		//zapisanie komunikatu do wyświetlenia administratorowi
		$_SESSION['accounts_message'] = "Usunięto konto partnera ".$_GET['firstname']." ".$_GET['secondname']."!";
		header('Location: accounts_management.php');
		exit();
	}
	else
	{
		header('Location: admin_panel.php');
		exit();
	}
}
else
{
	header('Location: index.php');
	exit();
}
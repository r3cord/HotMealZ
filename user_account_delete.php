<?php
session_start();

if(isset($_SESSION['logged_id_admin']))
{
	if(isset($_GET['user_id']))
	{
		//połączenie się z bazą danych
		require_once 'connect.php';
		
		//pobranie identyfikatorów potrzebnych do usunięcia danych związanych z klientem w innych tabelach bazy danych - list dań do zamówień i reklamacji
		$ordersQuery = $connection->query('SELECT id FROM orders WHERE id_user LIKE "'.$_GET['user_id'].'"');
		$orders = $ordersQuery->fetchAll();
		foreach ($orders as $order)
		{
			//usunięcie listy dań do zamówienia
			$odQuery = $connection->query('DELETE FROM od_connections WHERE id_order LIKE "'.$order['id'].'"');
			//usunięcie reklamacji do zamówienia
			$reclamationQuery = $connection->query('DELETE FROM reclamations WHERE id_order LIKE "'.$order['id'].'"');
		}
		//usunięcie zamówień klienta
		$ordersQuery_nd = $connection->query('DELETE FROM orders WHERE id_user LIKE "'.$_GET['user_id'].'"');
		//usunięcie rekordu z kontem klienta
		$userQuery = $connection->query('DELETE FROM users WHERE id LIKE "'.$_GET['user_id'].'"');
		
		//zapisanie komunikatu do wyświetlenia administratorowi
		$_SESSION['accounts_message'] = "Usunięto konto użytkownika ".$_GET['firstname']." ".$_GET['secondname']."!";
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
<?php
session_start();

if(isset($_SESSION['logged_id_admin']))
{
	if(isset($_GET['deliverer_id']))
	{
		//połączenie się z bazą danych
		require_once 'connect.php';
		
		//zmiana id dostawcy przy zamówieniach przez niego dostaraczanych na -1
		$ordersQuery = $connection->query('UPDATE orders SET id_deliverer = "-1" WHERE id_deliverer LIKE "'.$_GET['deliverer_id'].'"');
		//usunięcie rekordu z kontem dostawcy
		$userQuery = $connection->query('DELETE FROM deliverers WHERE id LIKE "'.$_GET['deliverer_id'].'"');
		
		//zapisanie komunikatu do wyświetlenia administratorowi
		$_SESSION['accounts_message'] = "Usunięto konto dostawcy ".$_GET['firstname']." ".$_GET['secondname']."!";
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
<?php
session_start();

if(isset($_SESSION['logged_id_admin']))
{
	if(isset($_GET['admin_id']))
	{
		if($_SESSION['logged_id_admin'] == $_GET['admin_id'])
		{
			$_SESSION['accounts_message'] = "Nie możesz usunąć konta admina, które jest aktualnie zalogowany!</br> Co, jeśli usuniesz wszystkich adminów? Będziesz dzwonił do nas, żebyśmy dodali nowego admina do bazy danych?</br> Ile ty masz lat? Pięć?";
			header('Location: accounts_management.php');
			exit();
		}
		else
		{
			//połączenie się z bazą danych
			require_once 'connect.php';
			
			//usunięcie rekordu z kontem admina
			$adminQuery = $connection->query('DELETE FROM admins WHERE id LIKE "'.$_GET['admin_id'].'"');
			
			//zapisanie komunikatu do wyświetlenia administratorowi
			$_SESSION['accounts_message'] = "Usunięto konto administratora ".$_GET['mail']."!";
			header('Location: accounts_management.php');
			exit();
		}
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
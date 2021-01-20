<?php
session_start();

if(isset($_SESSION['logged_id_admin']))
{
	if(isset($_POST['ban']))
	{
		//połączenie się z bazą danych
		require_once 'connect.php';
		
		//zaktualizowanie w bazie danych daty wygaśnięcia bana
		$userQuery = $connection->query('UPDATE users SET ban = "'.$_POST['ban'].'" WHERE id LIKE "'.$_POST['user_id'].'"');
		
		//zapisanie komunikatu do wyświetlenia administratorowi
		$_SESSION['accounts_message'] = "Zbanowano użytkownika ".$_POST['firstname']." ".$_POST['secondname']."!";
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
<?php

session_start();

if(isset($_SESSION['logged_id_partner']) == false)
{
	header('Location: index.php');
	exit();
}

if(isset($_POST['percentage']))
{
				
	require_once 'connect.php';	

	$query = $connection->prepare("CALL discount(?, ?)");
	$query->bindParam(1, $_POST['percentage'], PDO::PARAM_INT, 10);
	$query->bindParam(2, $_SESSION['logged_id_partner'], PDO::PARAM_INT, 10);
	
	$query->execute();
		
	$query=NULL;
	$_SESSION['e_discount'] = "Dania zostały przecenione!";
	header('Location: restaurant_panel.php');
	exit();
	
}
else
{
	header('Location: restaurant_panel.php');
	exit();
}
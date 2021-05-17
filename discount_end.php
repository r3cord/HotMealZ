<?php

session_start();

if(isset($_SESSION['logged_id_partner']) == false)
{
	header('Location: index.php');
	exit();
}
			
require_once 'connect.php';	

$query = $connection->prepare("CALL endDiscount(?)");
$query->bindParam(1, $_SESSION['logged_id_partner'], PDO::PARAM_INT, 10);
	
$query->execute();
		
$query=NULL;
$_SESSION['e_discount'] = "Przecena została zakończona!";
header('Location: restaurant_panel.php');
exit();
<?php
session_start();
if(isset($_POST['rest_name'])) //Sprawdzenie czy wymagane zmienne są ustalone
{
	unset($_SESSION['cart']); //Usunięcie tablicy, która jest koszykiem
	if($_POST['rest_name']!="cart.php") //Sprawdzenie czy aktualizacja jest robiona z korzyka czy nie
	{
		header('Location: dishes_list.php?rest='.$_POST['rest_name']); //Powrót do odpowiedniej strony
	}
	else
	{
		header('Location: cart.php');
	}
	exit();
}
else
{
	header('Location: index.php'); //Powrót do index.php
	exit();
}

?>


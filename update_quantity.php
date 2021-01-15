<?php
session_start();

if(isset($_POST['row']) && isset($_POST['quantity']) && isset($_POST['rest_name'])) //Sprawdzenie czy wymagane zmienne są ustalone
{
	$_SESSION['cart'][$_POST['row']][3]=$_POST['quantity']; //Aktualizacja ilości
	header('Location: dishes_list.php?rest='.$_POST['rest_name']); //Powrót do prawidłowej strony
	exit();
}
else
{
	header('Location: index.php'); //Jeżeli zmienne nie sa ustawione to wracamy do index.php
	exit();
}
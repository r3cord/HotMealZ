<?php
session_start();

if(isset($_POST['row']) && isset($_POST['quantity']) && isset($_POST['rest_name'])) //Sprawdzenie czy wymagane zmienne są ustalone
{
	$_SESSION['cart'][$_POST['row']][3]=$_POST['quantity']; //Aktualizacja ilości
	$_SESSION['cart'][$_POST['row']][5]=$_SESSION['cart'][$_POST['row']][4]*$_SESSION['cart'][$_POST['row']][3];
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
	header('Location: index.php'); //Jeżeli zmienne nie sa ustawione to wracamy do index.php
	exit();
}
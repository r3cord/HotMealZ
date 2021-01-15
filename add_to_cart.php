<?php
session_start();

if(!isset($_POST['id']) || !isset($_POST['quantity']) || !isset($_POST['restaurant_id']) || !isset($_POST['dish_name']) || !isset($_POST['price']) || !isset($_POST['rest_name']))
{
	header('Location: index.php'); //Przejście do index.php gdy zmienne $_POST nie są przesłane
	exit();
}

if(!isset($_SESSION['cart'] )) //Dodawanie dania w przypadku gdy zmienna koszyka nie jest jescz utworzona
{
	$full_price = $_POST['quantity']*$_POST['price']; //Obliczenie kosztu dodawanego elementu
	$_SESSION['cart'] = array( array($_POST['restaurant_id'], $_POST['id'], $_POST['dish_name'], $_POST['quantity'], $_POST['price'], $full_price));
	header('Location: dishes_list.php?rest='.$_POST['rest_name']);
	exit();
}
else //Dodawanie dania w przypadku gdy zmienna koszyka jest już utworzona
{
	$count = count($_SESSION['cart'] ); //sprawdzenie aktualnej ilości dań w tablicy
	$full_price = $_POST['quantity']*$_POST['price']; //Obliczenie kosztu dodawanego elementu
	$_SESSION['cart'][$count]=array($_POST['restaurant_id'], $_POST['id'], $_POST['dish_name'], $_POST['quantity'], $_POST['price'], $full_price); //Dodawanie nowego dania
	header('Location: dishes_list.php?rest='.$_POST['rest_name']);
	exit();
}

?>


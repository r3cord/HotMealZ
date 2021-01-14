<?php
session_start();

if(!isset($_POST['id']) || !isset($_POST['quantity']) || !isset($_POST['restaurant_id']) || !isset($_POST['dish_name']) || !isset($_POST['price']) || !isset($_POST['rest_name']))
{
	header('Location: index.php');
	exit();
}

if(!isset($_SESSION['cart'] ))
{
	$full_price = $_POST['quantity']*$_POST['price'];
	$_SESSION['cart'] = array( array($_POST['restaurant_id'], $_POST['id'], $_POST['dish_name'], $_POST['quantity'], $_POST['price'], $full_price));
	header('Location: dishes_list.php?rest='.$_POST['rest_name']);
	exit();
}
else
{
	$count = count($_SESSION['cart'] );
	$full_price = $_POST['quantity']*$_POST['price'];
	$_SESSION['cart'][$count]=array($_POST['restaurant_id'], $_POST['id'], $_POST['dish_name'], $_POST['quantity'], $_POST['price'], $full_price);
	//array_push($_SESSION['cart'][$count-1] , $_POST['restaurant_id'], $_POST['id'], $_POST['dish_name'], $_POST['quantity'], $_POST['price'], $full_price);
	header('Location: dishes_list.php?rest='.$_POST['rest_name']);
	exit();
}

?>


<?php
session_start();

if(isset($_POST['row']) && isset($_POST['quantity']) && isset($_POST['rest_name']))
{
	$_SESSION['cart'][$_POST['row']][3]=$_POST['quantity'];
	header('Location: dishes_list.php?rest='.$_POST['rest_name']);
	exit();
}
else
{
	header('Location: index.php');
	exit();
}
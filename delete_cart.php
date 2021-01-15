<?php
session_start();
if(isset($_POST['rest_name'])) //Sprawdzenie czy wymagane zmienne są ustalone
{
	unset($_SESSION['cart']); //Usunięcie tablicy, która jest koszykiem
	header('Location: dishes_list.php?rest='.$_POST['rest_name']); //Powrót do prawidłowej strony
	exit();
}
else
{
	header('Location: index.php'); //Powrót do index.php
	exit();
}

?>


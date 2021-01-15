<?php
session_start();
if(isset($_POST['row']) && isset($_POST['rest_name'])) //Sprawdzenie czy wymagane zmienne są ustalone
{
	array_splice($_SESSION['cart'], $_POST['row'], 1); //Usunięcie konkretnego dania z koszyka (z czego usuwamy, który wiersz, ile wierszy)
	header('Location: dishes_list.php?rest='.$_POST['rest_name']); //Powrót do odpowiedniej strony
	exit();
}
else
{
	header('Location: index.php'); //Powrót do index.php
	exit();
}

?>


<?php
session_start();
if(isset($_POST['id_restaurant']) && isset($_POST['id_order']) && isset($_POST['complaint'])) //Sprawdzenie czy wymagane zmienne są ustalone
{
	require_once 'connect.php';
	//Przygotowanie i wykonanie odpowiedniego zapytania do bazy MySQL (wstawienie reklamacji do tabeli reclamations)
	$addComplaintQuery = $connection->prepare('INSERT INTO reclamations VALUES (NULL, :id_order, :id_restaurant, :complaint, "W trakcie rozpatrywania")');
	$addComplaintQuery->bindValue(':id_order', $_POST['id_order'], PDO::PARAM_INT);
	$addComplaintQuery->bindValue(':id_restaurant', $_POST['id_restaurant'], PDO::PARAM_INT);
	$addComplaintQuery->bindValue(':complaint', $_POST['complaint'], PDO::PARAM_STR);
	$addComplaintQuery->execute();
	$addComplaintQuery = null;
	$_SESSION['complaint_success']="Twoja reklamacja została złożona!"; //Ustawienie zmiennej sesyjnej, która będzie informacją zwrotną
	header('Location: panel.php'); //Powrót do index.php
	exit();

}
else
{
	header('Location: index.php'); //Powrót do index.php
	exit();
}

?>


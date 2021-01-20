<?php
session_start();
if(isset($_POST['status']) && isset($_POST['id_complaint'])) //Sprawdzenie czy wymagane zmienne są ustalone
{
	if($_POST['status']!="W trakcie rozpatrywania")
	{
		require_once 'connect.php';
		//Przygotowanie i wykonanie odpowiedniego zapytania do bazy MySQL (aktualizacja statusu w reclamations)
		$changeComplaintQuery = $connection->query('UPDATE reclamations SET status="'.$_POST['status'].'" WHERE id="'.$_POST['id_complaint'].'"');
		$_SESSION['complaint_status']="Status reklamacji został zaktualizowany!"; //Ustawienie zmiennej sesyjnej, która będzie informacją zwrotną
		header('Location: complaint_panel.php'); //Powrót do panelu reklamacji partnera
		exit();
	}
	else
	{
		header('Location: complaint_panel.php'); //Powrót do panelu reklamacji partnera
		exit();
	}
}
else
{
	header('Location: index.php'); //Powrót do index.php
	exit();
}

?>


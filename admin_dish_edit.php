<?php

session_start();

if(isset($_SESSION['logged_id_admin']))
{
	if(!isset($_GET['id']))
	{
		header('Location: offer_management.php');
		exit();
	}
}
else
{
	header('Location: index.php');
	exit();
}

if(isset($_GET['dishname']))
{
	$validation=true;
				
	if($validation)
	{
		require_once 'connect.php';
		
		//przygotowanie i wykonanie zapytania do bazy danych uaktualniającego dane dania
		$query = $connection->prepare('UPDATE dishes SET name = :name, description = :description WHERE id LIKE '.$_GET['id']);
		$query->bindValue(':name', $_GET['dishname'], PDO::PARAM_STR);
		$query->bindValue(':description', $_GET['description'], PDO::PARAM_STR);
		$query->execute();
		$query=NULL;
		
		//ustawienie zmiennej sesyjnej potrzebnej do przeniesienia admina do oferty odpowiednej restauracji
		$_SESSION['restaurant_id'] = $_GET['restaurant_id'];
		header('Location: admin_restaurant_offer_changeform.php');
		exit();			
	}
	
	//opcja zostawiona na wszelki wypadek, na razie nie da się nie przejść walidacji
	if(!$validation)
	{
		//ustawienie zmiennych sesyjnych - zostaną one wpisane do formularza, żeby Admin nie musiał wpisywać ich drugi raz, a także zamienią zmienne wysłane metodą GET z admin_restaurant_offer_changeform w formularzu
		$_SESSION['given_dishname'] = $_GET['dishname'];
		$_SESSION['given_price'] = $_GET['price'];
		$_SESSION['given_description'] = $_GET['description'];
		$_SESSION['id_edit'] = $_GET['id'];
		$_SESSION['restaurant_id'] = $_GET['restaurant_id'];
		header('Location: admin_dish_editform.php');
		exit();
	}
}
else
{
	header('Location: offer_management.php');
}
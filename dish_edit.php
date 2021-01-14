<?php

session_start();

if(isset($_SESSION['logged_id_partner']))
{
	if(isset($_GET['id']))
	{
		;
	}
	else
	{
		header('Location: restaurant_offer_changeform.php');
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
		$query = $connection->prepare('UPDATE dishes SET name = :name, price = :price, description = :description WHERE id LIKE '.$_GET['id']);
		$query->bindValue(':name', $_GET['dishname'], PDO::PARAM_STR);
		$query->bindValue(':price', $_GET['price'], PDO::PARAM_STR);
		$query->bindValue(':description', $_GET['description'], PDO::PARAM_STR);
		$query->execute();
		
		//,,opróżnienie" zmiennych
		$query=NULL;
		//unset($_GET['id']);
		//unset($_GET['dishname']);
		//unset($_GET['price']);
		//unset($_GET['description']);
		
		header('Location: restaurant_offer_changeform.php');
		exit();
			
	}
	
	//opcja zostawiona na wszelki wypadek, na razie nie da się nie przejść walidacji
	if(!$validation)
	{
		//ustawienie zmiennych sesyjnych - zostaną one wpisane do formularza, żeby Partner nie musiał wpisywać ich drugi raz, a także zamienią zmienne wysłane metodą GET z restaurant_offer_changeform w formularzu
		$_SESSION['given_dishname'] = $_GET['dishname'];
		$_SESSION['given_price'] = $_GET['price'];
		$_SESSION['given_description'] = $_GET['description'];
		$_SESSION['id_edit'] = $_GET['id'];
		header('Location: dish_editform.php');
		exit();
	}
}
else
{
	header('Location: restaurant_offer_changeform.php');
}
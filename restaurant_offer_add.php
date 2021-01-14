<?php

session_start();

if(isset($_SESSION['logged_id_partner']) == false)
{
	header('Location: index.php');
	exit();
}

if(isset($_POST['dishname']))
{
	$validation=true;
				
	if($validation)
	{
		require_once 'connect.php';
		
		//pobranie id restauracji zalogowanego partnera do zmiennej $your_restaurant
		$restaurantQuery = $connection->query('SELECT id FROM restaurants WHERE id_partner LIKE "'.$_SESSION['logged_id_partner'].'"');
		$your_restaurant = $restaurantQuery->fetch();
		
		//kwerenda SQL dodająca danie do bazy; dodawanie danie ma parametry wpisane przez Partnera, a także id_restaurant pobrane z bazy danych, dzięki czemu możliwe jest powiązanie dania z restauracją Partnera
		$query = $connection->prepare('INSERT INTO dishes VALUES (NULL, '.$your_restaurant['id'].', :name, :price, :description, "")');
		$query->bindValue(':name', $_POST['dishname'], PDO::PARAM_STR);
		$query->bindValue(':price', $_POST['price'], PDO::PARAM_STR);
		$query->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
		$query->execute();
		
		$query=NULL;
		header('Location: restaurant_offer_changeform.php');
		exit();
			
	}
	
	//opcja zostawiona na wszelki wypadek, na razie nie da się nie przejść walidacji
	if(!$validation)
	{
		//ustawienie zmiennych sesyjnych - zostaną one wpisane do formularza, żeby Partner nie musiał wpisywać ich drugi raz
		$_SESSION['given_dishname'] = $_POST['dishname'];
		$_SESSION['given_price'] = $_POST['price'];
		$_SESSION['given_description'] = $_POST['description'];
		header('Location: restaurant_offer_changeform.php');
		exit();
	}
}
else
{
	header('Location: restaurant_offer_changeform.php');
}
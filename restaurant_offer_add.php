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
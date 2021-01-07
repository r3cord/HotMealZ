<?php

session_start();

if(isset($_SESSION['logged_id_partner']) == false)
{
	header('Location: index.php');
	exit();
}

if(isset($_POST['restaurantname']))
{
	$validation=true;
				
	if($validation)
	{
		require_once 'connect.php';
		
		$query = $connection->prepare('SELECT id FROM partners WHERE email = :email');
		$query->bindValue(':email', $email, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount()>0)
		{
			$validation=false;
			$_SESSION['e_email']="Już istnieje partner o takim e-mailu!";
			$query=NULL;
		}
		else
		{
			$query = $connection->prepare('UPDATE restaurants SET name = :name, description = :description, id_region = :id_region WHERE id_partner = '.$_SESSION['logged_id_partner']);
			$regionQuery = $connection->query('SELECT id FROM regions WHERE name LIKE "'.$_POST['region'].'"');
			$_id_region = $regionQuery->fetch();
			$id_region = $_id_region['id'];
			$query->bindValue(':name', $_POST['restaurantname'], PDO::PARAM_STR);
			$query->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
			$query->bindValue(':id_region', $id_region, PDO::PARAM_STR);
			$query->execute();
			
			$query=NULL;
			header('Location: restaurant_data_changeform.php');
			exit();
		}
				
	}
	
	//opcja zostawiona na wszelki wypadek, na razie nie da się nie przejść walidacji
	if(!$validation)
	{
		$_SESSION['given_restaurantname'] = $_POST['restaurantname'];
		$_SESSION['given_description'] = $_POST['description'];
		$_SESSION['given_region'] = $_POST['region'];
		header('Location: restaurant_data_changeform.php');
		exit();
	}
}
else
{
	header('Location: restaurant_data_changeform.php');
}
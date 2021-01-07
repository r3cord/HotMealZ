<?php

session_start();
if(isset($_SESSION['logged_id_partner']) == false)
{
	header('Location: index.php');
	exit();
}

?>

<!DOCTYPE html>
<html lang="pl">

	<head>

		<meta charset="utf-8">
		<title>HotMealZ</title>

		<meta name="description" content="Najlepszy w Polsce serwis do zamawiania jedzenia na dowóz z restauracji z całej Polski!">
		<meta name="keywords" content="dostawa, jedzenie, restauracje, restauracja, online, zamów, zamow, przez, internet, dowoz, dowóz, knajpa, knajpy">
		<meta name="author" content="Daniel Gaik & Jakub Foryś">

		<meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
		<link rel="stylesheet" href="style.css">

	</head>
	
	<body>	
		<header>

			<a href="index.php"><h1>HotMealZ</h1></a>

			
			<div class="button">
				<form action="logout_partner.php"><input type="submit" value="Wyloguj się"/></form>
			</div>
			
			<div class="button">
				<form action="index.php"><input type="submit" value="Bieżące zamówienia"/></form>
			</div>
			
		</header>
		
		<article>
			
			<div class="button">
				<form action="restaurant_data_changeform.php"><input type="submit" value="Zmień dane lokalu"/></form>
			</div>
			
			<div class="button">
				<form action="restaurant_panel.php"><input type="submit" value="Zmień ofertę lokalu"/></form>
			</div>
			
		</article>
	
	</body>

</html>
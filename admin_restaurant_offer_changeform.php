<?php

session_start();

if(isset($_SESSION['logged_id_admin']) == false)
{
	header('Location: index.php');
	exit();
}

//jeśli jest ustawiona zmienna sesyjna, to znaczy, że admin przed chwilą edytował ofertę tego lokalu - służy ona do tego, żeby nie musiał przechodzić do listy wszystkich lokali, jeżeli chciałby edytować kolejne danie w tym lokalu
if(isset($_SESSION['restaurant_id']))
{
	$_GET['restaurant_id'] = $_SESSION['restaurant_id'];
	unset($_SESSION['restaurant_id']);
}
else if(!isset($_GET['restaurant_id']))
{	
	header('Location: offer_management.php');
	exit();
}

require_once 'connect.php';

//pobranie danych restauracji o wybranym id do zmiennej $your_restaurant
$restaurantQuery = $connection->query('SELECT * FROM restaurants WHERE id LIKE "'.$_GET['restaurant_id'].'"');
$your_restaurant = $restaurantQuery->fetch();

//pobranie (posortowanych alfabetycznie) danych wszystkich dań w ofercie wybranego lokalu do zmiennej $your_offer
$offerQuery = $connection->query('SELECT * FROM dishes WHERE id_restaurant LIKE "'.$your_restaurant['id'].'" ORDER BY name');
$your_offer = $offerQuery->fetchAll();
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

			<div class="logo">
				<a href="admin_panel.php"><h1>HotMealZ</h1></a>
			</div>

			<div class="buttons">
				<form action="logout_admin.php"><input type="submit" value="Wyloguj się"/></form>
			</div>
			<div class="button">
			<form action="admin_panel.php"><input type="submit" value="Powrót do panelu admina"/></form>
			</div>
			<div class="button">
			<form action="offer_management.php"><input type="submit" value="Powrót do listy wszystkich lokali"/></form>
			</div>
			
		</header>
		
		<article>
			
				<table BORDER>
					<thead>
						<?php
						//napisanie nazwy wybranego lokalu oraz liczby dań w tym lokalu
							echo "<tr><td>Lokal: {$your_restaurant['name']}</td>
							<td>Liczba dań: ".$offerQuery->rowCount()."</td></tr>";
						?>
						<tr><td>NAZWA DANIA</td>
						<td>CENA DANIA</td>
						<td>OPIS DANIA</td></tr>
					</thead>
					<tbody>
						<?php
						//wypisanie, w formie tablicy, dań będących aktualnie w ofercie lokalu
						//linki w komórkach 4 i 5 prowadzą do akcji (odpowiednio) usuwania i edycji danych dania
						foreach ($your_offer as $dish) {
							echo "<tr name='{$dish['id']}'><td>{$dish['name']}</td>
							<td>{$dish['price']} zł</td>
							<td>{$dish['description']}</td>
							<td>
								<div class='button'>
								<a href='dish_remove.php?id={$dish['id']}&restaurant_id={$_GET['restaurant_id']}'>Usuń danie</a>
								</div>
							</td>
							<td>
								<div class='button'>
								<a href='admin_dish_editform.php?id={$dish['id']}&name={$dish['name']}&price={$dish['price']}&description={$dish['description']}&restaurant_id={$_GET['restaurant_id']}'>Edytuj danie</a>
								</div>
							</td></tr>";
						}
						?>
					</tbody>
				</table>
			
		</article>
	
	</body>

</html>
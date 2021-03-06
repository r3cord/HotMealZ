<?php

session_start();
if(isset($_SESSION['logged_id_partner']) == false)
{
	header('Location: index.php');
	exit();
}

require_once 'connect.php';

//pobranie danych restauracji zalogowanego partnera do zmiennej $your_restaurant
$restaurantQuery = $connection->query('SELECT * FROM restaurants WHERE id_partner LIKE "'.$_SESSION['logged_id_partner'].'"');
$your_restaurant = $restaurantQuery->fetch();

//pobranie (posortowanych alfabetycznie) danych wszystkich dań w ofercie zalogowanego partnera do zmiennej $your_offer
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
				<a href="index.php"><h1>HotMealZ</h1></a>
			</div>

			<div class="buttons">
				<form action="logout_partner.php"><input type="submit" value="Wyloguj się"/></form>
			</div>
			<div class="buttons">
				<form action="restaurant_panel.php"><input type="submit" value="Panel lokalu"/></form>
			</div>
			<div class="buttons">
				<form action="complaint_panel.php"><input type="submit" value="Reklamacje"/></form>
			</div>
			
		</header>
		
		<article>
			
				<table BORDER>
					<thead>
						<?php
						//napisanie nazwy lokalu zalogowanego partnera oraz liczby dań w tym lokalu
							echo "<tr><td>Lokal: {$your_restaurant['name']}</td>
							<td>Liczba dań: ".$offerQuery->rowCount()."</td></tr>";
						?>
						<tr><td>NAZWA DANIA</td>
						<td>CENA DANIA</td>
						<td>OPIS DANIA</td></tr>
					</thead>
					<tbody>
						<?php
						//wypisanie, w formie tablicy, dań będących aktualnie w ofercie partnera
						//linki w komórkach 4 i 5 prowadzą do akcji (odpowiednio) usuwania i edycji danych dania
						foreach ($your_offer as $dish) {
							echo "<tr name='{$dish['id']}'><td>{$dish['name']}</td>
							<td>{$dish['price']} zł</td>
							<td>{$dish['description']}</td>
							<td>
								<div class='button'>
								<a href='dish_remove.php?id={$dish['id']}'>Usuń danie</a>
								</div>
							</td>
							<td>
								<div class='button'>
								<a href='dish_editform.php?id={$dish['id']}&name={$dish['name']}&price={$dish['price']}&description={$dish['description']}'>Edytuj danie</a>
								</div>
							</td></tr>";
						}
						?>
					</tbody>
				</table>
			
			<div class="button">
				<form action="restaurant_offer_addform.php"><input type="submit" value="Dodaj danie do swojej oferty"/></form>
			</div>
			
		</article>
	
	</body>

</html>
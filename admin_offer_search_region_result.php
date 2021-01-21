<?php
	
session_start();

if(isset($_SESSION['logged_id_admin']) == false)
{
	header('Location: index.php');
	exit();
}

if(!isset($_POST['region_id']))
{	
	header('Location: offer_management.php');
	exit();
}
else require_once 'connect.php';
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

		<a href="admin_panel.php"><h1>HotMealZ</h1></a>
		
		<div class="button">
		<form action="logout_admin.php"><input type="submit" value="Wyloguj się"/></form>
		</div>
		
		<div class="button">
		<form action="admin_panel.php"><input type="submit" value="Powrót do panelu admina"/></form>
		</div>
		
	</header>
	
	<div class="button">
	<form action="offer_management.php"><input type="submit" value="Powrót do listy wszystkich lokali"/></form>
	</div>
	
	</br>
	
	<article>
			<!---wyświetlenie w tabeli lokali z danego regionu--->
			<table BORDER>
					<thead>
						<tr><td>LOKALE</td></tr>
						<tr><td>Nazwa</td><td>Opis</td><td>Region</td></tr>
					</thead>
					
					<tbody>
					<?php
						//dzięki temu, że tutaj każdy lokal ma takie samo id_region, można pobrać mniej danych o jedną kolumnę, a także wyeliminować pętle foreach pobierającą z bazy danych nazwę regionu dla każdego lokalu - teraz wystarczy to zrobić raz dla wszystkich lokali
						$restaurantsQuery = $connection->query('SELECT id, name, description FROM restaurants WHERE id_region LIKE "'.$_POST['region_id'].'"');
						$restaurants = $restaurantsQuery->fetchAll();
						
						$regionQuery = $connection->query('SELECT name FROM regions WHERE id LIKE "'.$_POST['region_id'].'"');
						$region = $regionQuery->fetch();
						$region_name = $region['name'];
						
						foreach($restaurants as $restaurant)
						{
							echo "<tr><td>{$restaurant['name']}</td>
							<td>{$restaurant['description']}</td>
							<td>{$region_name}</td>
							<td>
							<div class='button'>
							<a href='admin_restaurant_offer_changeform.php?restaurant_id={$restaurant['id']}'>Przejdź do oferty tego lokalu</a>
							</div>			
							</td></tr>";
						}
					?>
					</tbody>
			</table>
	</article>
	</body>

</html>
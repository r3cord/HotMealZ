<?php
	
session_start();

if(isset($_SESSION['logged_id_admin']) == false)
{
	header('Location: index.php');
	exit();
}

if(!isset($_POST['name']))
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

		<div class="logo">
			<a href="admin_panel.php"><h1>HotMealZ</h1></a>
		</div>
		
		<div class="buttons">
		<form action="logout_admin.php"><input type="submit" value="Wyloguj się"/></form>
		</div>
		
		<div class="buttons">
		<form action="admin_panel.php"><input type="submit" value="Powrót do panelu admina"/></form>
		</div>
		
	</header>
	
	<div class="button">
	<form action="offer_management.php"><input type="submit" value="Powrót do listy wszystkich lokali"/></form>
	</div>
	
	<div class="button">
	<form action="admin_offer_search.php"><input type="submit" value="Wyszukaj inny lokal"/></form>
	</div>
	
	</br>
	
	<article>
			<!---informacja dla admina o wpisanym przez niego wyrazie--->
			<?= "Wyszukujesz lokal: ".$_POST['name'] ?>
			
			</br></br>
	
			<!---wyświetlenie w tabeli lokali z interesującymi danymi--->
			<table BORDER>
					<thead>
						<tr><td>LOKALE</td></tr>
						<tr><td>Nazwa</td><td>Opis</td><td>Region</td></tr>
					</thead>
					
					<tbody>
					<?php
						$restaurantsQuery = $connection->prepare('SELECT id, id_region, name, description FROM restaurants WHERE name LIKE CONCAT("%", :name, "%")');
						$restaurantsQuery->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
						$restaurantsQuery->execute();
						$restaurants = $restaurantsQuery->fetchAll();
						$restaurantsQuery=NULL;
						
						foreach($restaurants as $restaurant)
						{
							echo "<tr><td>{$restaurant['name']}</td>
							<td>{$restaurant['description']}</td>";
							
							$regionQuery = $connection->query('SELECT name FROM regions WHERE id LIKE "'.$restaurant['id_region'].'"');
							$region = $regionQuery->fetch();
							echo "<td>{$region['name']}</td>
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
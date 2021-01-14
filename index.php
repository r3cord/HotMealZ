<?php

session_start();

require_once 'connect.php';
$regionsQuery = $connection->query('SELECT name FROM regions');
$Qregions = $regionsQuery->fetchAll();
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
				<?php
				if(isset($_SESSION['logged_id']))
				{
					echo '<form action="logout.php"><input type="submit" value="Wyloguj się"/></form>';
				}
				else if(isset($_SESSION['logged_id_partner']))
				{
					echo '<form action="logout_partner.php"><input type="submit" value="Wyloguj się"/></form>';
				}
				else
				{
					echo '<form action="loginform.php"><input type="submit" value="Zaloguj się!"/></form>';
					echo '<form action="registerform.php"><input type="submit" value="Zarejestruj się"/></form>';
				}
				?>
			</div>
			
			<div class="buttons">
				<?php
				if(isset($_SESSION['logged_id']))
				{
					echo '<form action="index.php"><input type="submit" value="Panel"/></form>';
				}
				else if(isset($_SESSION['logged_id_partner']))
				{
					echo '<form action="restaurant_panel.php"><input type="submit" value="Panel Lokalu"/></form>';
				}
				else
				{
					echo '<form action="loginform_partner.php"><input type="submit" value="Zaloguj się jako Partner!"/></form>';
					echo '<form action="registerform_partner.php"><input type="submit" value="Zarejestruj się jako Partner"/></form>';
				}
				?>
			</div>
		</header>
		
		<article>
		<?php
		if(!isset($_SESSION['logged_id_partner']))
			{
			echo "<div class='form'>
				<h1>Zamów jedzenie z Twojej ulubionej restauracji!</h1></br>
				Wybierz region:
					<form method='post' action='restaurant_list.php'>
					Region: <select name='region'>";
						foreach ($Qregions as $Qregion) 
						{
							echo "<option>{$Qregion['name']}</option>";
						}
					echo "</select>
					</br>
					</br>
					<input type='submit' value='Pokaż restauracje!'/>
					</form>
			</div>";
			}
			else
			{
				//pobranie z bazy danych rekordów potrzebnych do wyświetlenia informacji o aktualnych zamówieniach
				$restaurantQuery = $connection->query('SELECT * FROM restaurants WHERE id_partner LIKE "'.$_SESSION['logged_id_partner'].'"');
				$your_restaurant = $restaurantQuery->fetch();
				$ordersQuery = $connection->query('SELECT * FROM orders WHERE id_restaurant LIKE "'.$your_restaurant['id'].'" AND (status LIKE "w trakcie przygotowania" OR status LIKE "oczekujące")');
				$currentOrders = $ordersQuery->fetchAll();
				
				//wyświetlenie w tablicy informacji o zamówieniach ze statusem "w trakcie przygotowania" łącznie z listą dań utworzoną za pomocą tablicy od_connections z bazy danych
				//ostatnia komórka w tablicy jest hiperłączem do zmiany statusu zamówienia na "oczekujące"
				echo "<table BORDER>
					<thead>
						<tr><td>ZAMÓWIENIA W TRAKCIE PRZYGOTOWANIA</td></tr>
						<tr><td>Data złożenia zamówienia</td><td>Wartość</td><td>Dania</td></tr>
					</thead>
					<tbody>";
						foreach ($currentOrders as $order)
						{
							if ($order['status'] == "w trakcie przygotowania")
							{
/*<tr name='{$dish['id']}'>*/	echo "<tr><td>{$order['order_date']}</td>
								<td>{$order['price']} zł</td><td>";
								
								$dishes_listQuery = $connection->query('SELECT * FROM od_connections WHERE id_order LIKE "'.$order['id'].'"');
								$dishes_list = $dishes_listQuery->fetchAll();
								foreach ($dishes_list as $dish)
								{
									$dishesQuery = $connection->query('SELECT name FROM dishes WHERE id LIKE "'.$dish['id_dish'].'"');
									$dish_name = $dishesQuery->fetch();
									echo $dish['amount']." razy ".$dish_name['name']." </br>";
								}
								
								echo"</td><td>
									<div class='button'>
									<a href='order_status_update1.php?order_id={$order['id']}&region_id={$your_restaurant['id_region']}'>Zmień status na |oczekujące|</a>
									</div>
								</td></tr>";
							}
						}
					echo "</tbody>
				</table>";
				
				echo "</br></br>";
				
				//wyświetlenie w tablicy informacji o zamówieniach ze statusem "oczekujące" łącznie z listą dań utworzoną za pomocą tablicy od_connections z bazy danych
				//ostatnia komórka w tablicy jest hiperłączem do zmiany statusu zamówienia na "w trakcie dostawy"
				echo "<table BORDER>
					<thead>
						<tr><td>ZAMÓWIENIA OCZEKUJĄCE NA DOSTAWĘ</td></tr>
						<tr><td>Data złożenia zamówienia</td><td>Wartość</td><td>Dania</td></tr>
					</thead>
					<tbody>";
						foreach ($currentOrders as $order)
						{
							if ($order['status'] == "oczekujące")
							{
/*<tr name='{$dish['id']}'>*/	echo "<tr><td>{$order['order_date']}</td>
								<td>{$order['price']} zł</td><td>";
								
								$dishes_listQuery = $connection->query('SELECT * FROM od_connections WHERE id_order LIKE "'.$order['id'].'"');
								$dishes_list = $dishes_listQuery->fetchAll();
								foreach ($dishes_list as $dish)
								{
									$dishesQuery = $connection->query('SELECT name FROM dishes WHERE id LIKE "'.$dish['id_dish'].'"');
									$dish_name = $dishesQuery->fetch();
									echo $dish['amount']." razy ".$dish_name['name']." </br>";
								}
								
								echo"</td><td>
									<div class='button'>
									<a href='order_status_update2.php?id={$order['id']}'>Zmień status na |w trakcie dostawy|</a>
									</div>
								</td></tr>";
							}
						}
					echo "</tbody>
				</table>";
			}
		?>
		</article>
	
	</body>

</html>
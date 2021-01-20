<?php

session_start();
if(isset($_SESSION['logged_id_admin']) == false)
{
	header('Location: index.php');
	exit();
}

require_once 'connect.php';
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
			
		</header>
		
		<article>
			
			<div class="button">
				<form action="deliverer_search.php"><input type="submit" value="Wyszukaj dostawcę"/></form>
			</div>
			
			<div class="button">
				<form action="deliverer_search_region.php"><input type="submit" value="Wyszukaj dostawców z danego regionu"/></form>
			</div>
			
			</br>
			<?php
			//wyświetlenie ewentualnego komunikatu z powodzenia operacji interaktywnych
			if(isset($_SESSION['deliverers_message'])) 
			{
				echo $_SESSION['deliverers_message']."</br></br>";
				unset($_SESSION['deliverers_message']);
			}
			?>
			
			<!---wyświetlenie w tabeli kont dostawców--->
			<table BORDER>
					<thead>
						<tr><td>KONTA DOSTAWCÓW</td></tr>
						<tr><td>Imię</td><td>Nazwisko</td><td>e-mail</td><td>Telefon</td><td>Region</td></tr>
					</thead>
					
					<tbody>
					<?php 
						$deliverersQuery = $connection->query('SELECT id, id_region, firstname, secondname, email, phone FROM deliverers');
						$deliverers = $deliverersQuery->fetchAll();
						
						foreach($deliverers as $deliverer)
						{
							echo "<tr><td>{$deliverer['firstname']}</td>
							<td>{$deliverer['secondname']}</td>
							<td>{$deliverer['email']}</td>
							<td>{$deliverer['phone']}</td>";
							
							if($deliverer['id_region'] == -1)
							{
								echo "<td>NIEPRZYPISANY</td>
								<td>
								<div class='button'>
								<a href='deliverer_region_changeform.php?deliverer_id={$deliverer['id']}&firstname={$deliverer['firstname']}&secondname={$deliverer['secondname']}&region_id={$deliverer['id_region']}&region=NIEPRZYPISANY'>Zmień region</a>
								</div>		
								</td></tr>";
							}
							else
							{
								$regionQuery = $connection->query('SELECT name FROM regions WHERE id LIKE "'.$deliverer['id_region'].'"');
								$region = $regionQuery->fetch();
								echo "<td>{$region['name']}</td>
								<td>
								<div class='button'>
								<a href='deliverer_region_changeform.php?deliverer_id={$deliverer['id']}&firstname={$deliverer['firstname']}&secondname={$deliverer['secondname']}&region_id={$deliverer['id_region']}&region={$region['name']}'>Zmień region</a>
								</div>		
								</td></tr>";
							}
						}
					?>
					</tbody>
			</table>
			
		</article>
	
	</body>

</html>
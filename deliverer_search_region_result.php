<?php
	
session_start();

if(isset($_SESSION['logged_id_admin']) == false)
{
	header('Location: index.php');
	exit();
}

if(!isset($_POST['region_id']))
{	
	header('Location: deliverers_management.php');
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
	<form action="deliverers_management.php"><input type="submit" value="Powrót do listy wszystkich dostawców"/></form>
	</div>
	
	</br>
	
	<article>
			<!---wyświetlenie w tabeli kont dostawców z danego regionu--->
			<table BORDER>
					<thead>
						<tr><td>KONTA DOSTAWCÓW</td></tr>
						<tr><td>Imię</td><td>Nazwisko</td><td>e-mail</td><td>Telefon</td><td>Region</td></tr>
					</thead>
					
					<tbody>
					<?php
						//dzięki temu, że tutaj każdy dostawca ma takie samo id_region, można pobrać mniej danych o jedną kolumnę, a także wyeliminować pętle foreach pobierającą z bazy danych nazwę regionu dla każdego dostawcy - teraz wystarczy to zrobić raz dla wszystkich dostawców
						$deliverersQuery = $connection->query('SELECT id, firstname, secondname, email, phone FROM deliverers WHERE id_region LIKE "'.$_POST['region_id'].'"');
						$deliverers = $deliverersQuery->fetchAll();
						
						if($_POST['region_id'] == -1) $region_name = "NIEPRZYPISANY";
						else
						{
							$regionQuery = $connection->query('SELECT name FROM regions WHERE id LIKE "'.$_POST['region_id'].'"');
							$region = $regionQuery->fetch();
							$region_name = $region['name'];
						}
						
						foreach($deliverers as $deliverer)
						{
							echo "<tr><td>{$deliverer['firstname']}</td>
							<td>{$deliverer['secondname']}</td>
							<td>{$deliverer['email']}</td>
							<td>{$deliverer['phone']}</td>
							<td>{$region_name}</td>
							<td>
							<div class='button'>
							<a href='deliverer_region_changeform.php?deliverer_id={$deliverer['id']}&firstname={$deliverer['firstname']}&secondname={$deliverer['secondname']}&region_id={$_POST['region_id']}&region={$region_name}'>Zmień region</a>
							</div>		
							</td></tr>";
						}
					?>
					</tbody>
			</table>
	</article>
	</body>

</html>
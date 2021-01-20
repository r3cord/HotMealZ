<?php
	
session_start();

if(isset($_SESSION['logged_id_admin']) == false)
{
	header('Location: index.php');
	exit();
}

if(!isset($_POST['firstname']))
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
	
	<div class="button">
	<form action="deliverer_search.php"><input type="submit" value="Wyszukaj innego dostawcę"/></form>
	</div>
	
	</br>
	
	<article>
			<!---informacja dla admina o wpisanych przez niego wyrazach--->
			<?= "Wyszukujesz</br>imię: ".$_POST['firstname']."</br>nazwisko: ".$_POST['secondname']."</br>e-mail: ".$_POST['email'] ?>
			
			</br></br>
	
			<!---wyświetlenie w tabeli kont dostawców z interesującymi danymi--->
			<table BORDER>
					<thead>
						<tr><td>KONTA DOSTAWCÓW</td></tr>
						<tr><td>Imię</td><td>Nazwisko</td><td>e-mail</td><td>Telefon</td><td>Region</td></tr>
					</thead>
					
					<tbody>
					<?php
						$deliverersQuery = $connection->prepare('SELECT id, id_region, firstname, secondname, email, phone FROM deliverers WHERE firstname LIKE CONCAT("%", :firstname, "%") AND secondname LIKE CONCAT("%", :secondname, "%") AND email LIKE CONCAT("%", :email, "%")');
						$deliverersQuery->bindValue(':firstname', $_POST['firstname'], PDO::PARAM_STR);
						$deliverersQuery->bindValue(':secondname', $_POST['secondname'], PDO::PARAM_STR);
						$deliverersQuery->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
						$deliverersQuery->execute();
						$deliverers = $deliverersQuery->fetchAll();
						$deliverersQuery=NULL;
						
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
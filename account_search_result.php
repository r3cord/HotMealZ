<?php
	
session_start();

if(isset($_SESSION['logged_id_admin']) == false)
{
	header('Location: index.php');
	exit();
}

if(!isset($_POST['firstname']))
{	
	header('Location: accounts_management.php');
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
		<div class="logo">
		
		<div class="buttons">
		<form action="logout_admin.php"><input type="submit" value="Wyloguj się"/></form>
		</div>
		
		<div class="buttons">
		<form action="admin_panel.php"><input type="submit" value="Powrót do panelu admina"/></form>
		</div>
		
	</header>
	
	<div class="button">
	<form action="accounts_management.php"><input type="submit" value="Powrót do listy wszystkich kont"/></form>
	</div>
	
	<div class="button">
	<form action="account_search.php"><input type="submit" value="Wyszukaj inne konto"/></form>
	</div>
	
	</br>
	
	<article>
			<!---informacja dla admina o wpisanych przez niego wyrazach--->
			<?= "Wyszukujesz</br>imię: ".$_POST['firstname']."</br>nazwisko: ".$_POST['secondname']."</br>e-mail: ".$_POST['email'] ?>
			
			</br></br>
	
			<!---wyświetlenie w tabeli kont użytkowników z interesującymi danymi--->
			<table BORDER>
					<thead>
						<tr><td>KONTA UŻYTKOWNIKÓW</td></tr>
						<tr><td>Imię</td><td>Nazwisko</td><td>e-mail</td><td>Numer telefonu</td><td>Adres</td><td>Data wygaśnięcia bana</td></tr>
					</thead>
					
					<tbody>
					<?php 
						$usersQuery = $connection->prepare('SELECT id, firstname, secondname, email, phone, address, postcode, city, ban FROM users WHERE firstname LIKE CONCAT("%", :firstname, "%") AND secondname LIKE CONCAT("%", :secondname, "%") AND email LIKE CONCAT("%", :email, "%")');
						$usersQuery->bindValue(':firstname', $_POST['firstname'], PDO::PARAM_STR);
						$usersQuery->bindValue(':secondname', $_POST['secondname'], PDO::PARAM_STR);
						$usersQuery->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
						$usersQuery->execute();
						$users = $usersQuery->fetchAll();
						$usersQuery=NULL;
						
						foreach($users as $user)
						{
							echo "<tr><td>{$user['firstname']}</td>
							<td>{$user['secondname']}</td>
							<td>{$user['email']}</td>
							<td>{$user['phone']}</td>
							<td>{$user['address']}, {$user['postcode']} {$user['city']}</td>
							<td>{$user['ban']}</td>
							<td>
							<div class='button'>
							<a href='banform.php?user_id={$user['id']}&firstname={$user['firstname']}&secondname={$user['secondname']}'>Zbanuj</a>
							</div>		
							</td>
							<td>
							<div class='button'>
							<a href='user_account_delete.php?user_id={$user['id']}&firstname={$user['firstname']}&secondname={$user['secondname']}'>Usuń konto</a>
							</div>		
							</td></tr>";
						}
					?>
					</tbody>
			</table>
			
			</br></br>
			
			<!---wyświetlenie w tabeli kont partnerów z interesującymi danymi--->
			<table BORDER>
					<thead>
						<tr><td>KONTA PARTNERÓW</td></tr>
						<tr><td>Imię</td><td>Nazwisko</td><td>e-mail</td><td>Lokal</td><td>Region</td></tr>
					</thead>
					
					<tbody>
					<?php 					
						$partnersQuery = $connection->prepare('SELECT id, firstname, secondname, email FROM partners WHERE firstname LIKE CONCAT("%", :firstname, "%") AND secondname LIKE CONCAT("%", :secondname, "%") AND email LIKE CONCAT("%", :email, "%")');
						$partnersQuery->bindValue(':firstname', $_POST['firstname'], PDO::PARAM_STR);
						$partnersQuery->bindValue(':secondname', $_POST['secondname'], PDO::PARAM_STR);
						$partnersQuery->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
						$partnersQuery->execute();
						$partners = $partnersQuery->fetchAll();
						$partnersQuery=NULL;
						
						foreach($partners as $partner)
						{
							echo "<tr><td>{$partner['firstname']}</td>
							<td>{$partner['secondname']}</td>
							<td>{$partner['email']}</td>";
							
							$restaurantQuery = $connection->query('SELECT name, id_region FROM restaurants WHERE id_partner LIKE "'.$partner['id'].'"');
							$restaurant = $restaurantQuery->fetch();
							$regionQuery = $connection->query('SELECT name FROM regions WHERE id LIKE "'.$restaurant['id_region'].'"');
							$region = $regionQuery->fetch();
							
							echo "<td>{$restaurant['name']}</td><td>{$region['name']}</td>
							<td>
							<div class='button'>
							<a href='partner_account_delete.php?partner_id={$partner['id']}&firstname={$partner['firstname']}&secondname={$partner['secondname']}'>Usuń konto</a>
							</div>		
							</td></tr>";
						}
					?>
					</tbody>
			</table>
			
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
								echo "<td>NIEPRZYPISANY</td>";
							}
							else
							{
								$regionQuery = $connection->query('SELECT name FROM regions WHERE id LIKE "'.$deliverer['id_region'].'"');
								$region = $regionQuery->fetch();
								echo "<td>{$region['name']}</td>";
							}
							
							echo "<td>
							<div class='button'>
							<a href='deliverer_account_delete.php?deliverer_id={$deliverer['id']}&firstname={$deliverer['firstname']}&secondname={$deliverer['secondname']}'>Usuń konto</a>
							</div>		
							</td></tr>";
						}
					?>
					</tbody>
			</table>
			
			</br></br>
			
			<!---wyświetlenie w tabeli kont administratorów z interesującymi danymi--->
			<table BORDER>
					<thead>
						<tr><td>KONTA ADMINISTRATORÓW</td></tr>
						<tr><td>e-mail</td></tr>
					</thead>
					
					<?php
						//admin ma tylko e-mail, więc trzeba sprawdzić najpierw czy w ogóle konta admina szukał wpisujący - jeśli wpisał imię i/lub nazwisko, to znaczy, że nie
						if($_POST['firstname'] == "" && $_POST['secondname'] == "")
						{
							$adminsQuery = $connection->prepare('SELECT id, email FROM admins WHERE email LIKE CONCAT("%", :email, "%")');
							$adminsQuery->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
							$adminsQuery->execute();
							$admins = $adminsQuery->fetchAll();
							$adminsQuery=NULL;
							
							foreach($admins as $admin)
							{
								echo "<tbody><tr>
								<td>{$admin['email']}</td>
								<td>
								<div class='button'>
								<a href='admin_account_delete.php?admin_id={$admin['id']}&mail={$admin['email']}'>Usuń konto</a>
								</div>		
								</td></tr></tbody>";
							}
						}
					?>
			</table>
	</article>
	</body>

</html>
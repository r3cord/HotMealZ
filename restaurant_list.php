<?php
session_start();

if(!isset($_POST['region']) || isset($_SESSION['logged_id_partner']))
{
	header('Location: index.php');
	exit();
}

//Pobranie odpowiednich danych z bazy danych
require_once 'connect.php';
$region_idQuery = $connection->query('SELECT id FROM regions WHERE name LIKE "'.$_POST['region'].'"');
$region_id = $region_idQuery->fetch();
$restaurantsQuery = $connection->query('SELECT name,description FROM restaurants WHERE id_region='.$region_id['id']);
$restaurants = $restaurantsQuery->fetchAll();


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
				if(isset($_SESSION['logged_id'])) //Jeżeli zalogowano
				{
					echo '<form action="logout.php"><input type="submit" value="Wyloguj się"/></form>';
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
				else
				{
					echo '<form action="loginform_partner.php"><input type="submit" value="Zaloguj się jako Partner!"/></form>';
					echo '<form action="registerform_partner.php"><input type="submit" value="Zarejestruj się jako Partner"/></form>';
				}
				?>
			</div>
			<div class="buttons">
				<?php
				if(isset($_SESSION['logged_id']))
				{
					echo '<form action="cart.php"><input type="submit" value="Koszyk"/></form>';
				}
				?>
			</div>
		</header>
		
		<article>
			<div class="list">
			<h1>Restauracje znajdujące się w regionie <?php echo $_POST['region'];?></h1>
			</br>
				<table class="fixed">
					<thead>
						<tr>
							<th>Nazwa</th>
							<th>Opis</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
					//Wyświetlenie wszystkich dostępnych restauracji w danym regionie w tabeli
						if(isset($restaurants))
						{
							foreach ($restaurants as $restaurant) 
							{
								echo "<tr>";
									echo "<td>" . $restaurant['name'] . "</td>";
									echo "<td>" . $restaurant['description'] . "</td>";				
									echo "<td><form method='get' action='dishes_list.php'><input type='submit' value='Wybierz'><input type='hidden' value='".$restaurant['name']."' name='rest' /></form></td>";
								echo "</tr>";
							}
						}
						else
						{
							echo "Brak restauracji w tym regionie!";
						}
					?>
					</tbody>
				</table>
			</div>
		</article>
	
	</body>

</html>
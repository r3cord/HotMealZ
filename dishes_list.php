<?php
session_start();

if(!isset($_GET['rest']))
{
	header('Location: index.php');
	exit();
}

require_once 'connect.php';
$restaurant_idQuery = $connection->prepare('SELECT id FROM restaurants WHERE name = :name');
$restaurant_idQuery->bindValue(':name', $_GET['rest'], PDO::PARAM_STR);
$restaurant_idQuery->execute();
if($restaurant_idQuery->rowCount()==0)
{
	header('Location: index.php');
	exit();
}
$restaurant_id = $restaurant_idQuery->fetch();
$dishesQuery = $connection->query('SELECT name,price,description FROM dishes WHERE id_restaurant='.$restaurant_id['id']);
$dishes = $dishesQuery->fetchAll();

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
		
		<script src="getValueFromCell.js"></script>


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
			<div class="list" >
			<h1>Dania z restauracji <?php echo $_GET['rest'];?></h1>
			</br>
				<table class="fixed">
					<thead>
						<tr>
							<th>Nazwa</th>
							<th>Opis</th>
							<th>Cena</th>
							<th>ilość</th>
							<th>Dodaj</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if(isset($dishes))
						{
							foreach ($dishes as $dish) 
							{
								echo "<tr>";
									echo "<td>" . $dish['name'] . "</td>";
									echo "<td>" . $dish['description'] . "</td>";			
									echo "<td>" . $dish['price'] . "zł</td>";
									echo "<td>5</td>";												
									echo "<td><a class='button' href='dishes_list.php?rest=".$dish['name']."'>Dodaj</a></td>";
								echo "</tr>";
							}
						}
						else
						{
							echo "Brak dodanych dań w tej restauracji!";
						}
					?>
					</tbody>
				</table>
				</br>
				<h1>Koszyk:</h1>
			</div>

		</article>
	
	</body>

</html>
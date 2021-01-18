<?php
session_start();

if(!isset($_GET['rest']) || isset($_SESSION['logged_id_partner']))
{
	header('Location: index.php');
	exit();
}

require_once 'connect.php';
$restaurant_idQuery = $connection->prepare('SELECT id FROM restaurants WHERE name = :name');
$restaurant_idQuery->bindValue(':name', $_GET['rest'], PDO::PARAM_STR);
$restaurant_idQuery->execute();
//Jeżeli restauracja o nazwie $_GET['rest'] nie istnieje to wracamy do index.php
if($restaurant_idQuery->rowCount()==0)
{
	header('Location: index.php');
	exit();
}
//Pobranie odpowiednich danych z bazy danych
$restaurant_id = $restaurant_idQuery->fetch();
$dishesQuery = $connection->query('SELECT id,name,price,description FROM dishes WHERE id_restaurant='.$restaurant_id['id']);
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
				else //Jeżeli nie jest się zalogowanym
				{
					echo '<form action="loginform.php"><input type="submit" value="Zaloguj się!"/></form>';
					echo '<form action="registerform.php"><input type="submit" value="Zarejestruj się"/></form>';
				}
				?>
			</div>
			
			<div class="buttons">
				<?php
				if(isset($_SESSION['logged_id'])) //Jeżeli zalogowano
				{
					echo '<form action="panel.php"><input type="submit" value="Panel"/></form>';
				}
				else //Jeżeli nie jest się zalogowanym
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
					//Wyświetlenie dań z konkretnej restauracji
						if(isset($dishes))
						{
							foreach ($dishes as $dish) 
							{
								echo "<tr>";
									echo "<td>" . $dish['name'] . "</td>";
									echo "<td>" . $dish['description'] . "</td>";			
									echo "<td>" . $dish['price'] . "zł</td>";
									if(isset($_SESSION['logged_id']))
									{
										echo "<td><form method='post' action='add_to_cart.php'><input type='hidden' name='id' value='".$dish['id']."'/><input type='hidden' name='restaurant_id' value='".$restaurant_id['id']."'/><input type='hidden' name='dish_name' value='".$dish['name']."'/><input type='hidden' name='price' value='".$dish['price']."'/><input type='hidden' name='rest_name' value='".$_GET['rest']."'/><input class='quantity' type='number' step='1' min='1' max='999' name='quantity' required /></td>";
										echo "<td><input type='submit' value='Dodaj' /></form></td>";										
									}			
									else
									{
										echo "<td colspan='2'>Musisz się zalogować!</td>";
									}
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
				
					<?php 
					if(isset($_SESSION['logged_id'])) //Jeżeli zalogowano to można dodawać rzeczy do koszyka
					{
						if(isset($_SESSION['cart']) && isset($_SESSION['cart'][0]))
						{
							if($_SESSION['cart'][0][0]==$restaurant_id['id'])
							{
								echo "
								<table class='fixed_cart'>
									<tbody>
										<thead>
											<tr>
												<th>Nazwa</th>
												<th>Ilość</th>
												<th>Cena/szt</th>
												<th>Koszt</th>
												<th>Usuń</th>
											</tr>
										</thead>";
							$array = $_SESSION['cart'];
							$count = count($array);
							$sum=0;
							for($i=0; $i<$count; $i++)
							{
								echo "<tr>";
									echo "<td>" . $array[$i][2] . "</td>";
									echo "<td><form method='post' action='update_quantity.php'><input class='quantity' type='number' step='1' min='1' max='999' name='quantity' value='".$array[$i][3]."' required /><input type='submit' value='Aktualizuj' /><input type='hidden' value='".$i."' name='row' /><input type='hidden' name='rest_name' value='".$_GET['rest']."'/></form></td>";		
									echo "<td>" . $array[$i][4] . "zł</td>";		
									echo "<td>" . $array[$i][5] . "zł</td>";												
									echo "<td><form method='post' action='delete_dish_from_cart.php'><input type='submit' value='Usuń' /><input type='hidden' value='".$i."' name='row' /><input type='hidden' name='rest_name' value='".$_GET['rest']."'/></form></td>";
								echo "</tr>";
								$sum=$sum+$array[$i][5];
							}
							echo "</tbody>	
				                    </table>
									<h3>Suma: ".$sum." zł</h3>
									<form method ='post' action='delete_cart.php'><input type='submit' value='Opróżnij koszyk' /><input type='hidden' name='rest_name' value='".$_GET['rest']."'/></form></br>
									Dodaj uwagi do zamówienia:
									<form method ='post' action='submit_order.php'><textarea type='text' class='description' name='comments'></textarea></br>
									<input type='submit' value='Złóż zamówienie' /><input type='hidden' value='".$sum."' name='sum' /></form>";
							}
							else
							{
								echo "<p><span style='color:red'>Do koszyka można dodawać dania tylko z tej samej restauracji! Twój koszyk został opróżniony!</span></p>
										   <p>Możesz już dodawać nowe dania!</p>";
								unset($_SESSION['cart']);
							}
				
						}
						else echo "Koszyk jest pusty";
					}
					else //Jeżeli nie to nie ma możliwości dodawania dań do koszyka
					{
						echo "Aby dodawać rzeczy do koszyka musisz być zalogowany/a!";
					}
					?>

			</div>

		</article>
	
	</body>

</html>
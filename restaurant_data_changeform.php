<?php

session_start();
if(isset($_SESSION['logged_id_partner']) == false)
{
	header('Location: index.php');
	exit();
}

require_once 'connect.php';

$restaurantQuery = $connection->query('SELECT * FROM restaurants WHERE id_partner LIKE "'.$_SESSION['logged_id_partner'].'"');
$your_restaurant = $restaurantQuery->fetch();

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
				<form action="logout_partner.php"><input type="submit" value="Wyloguj się"/></form>
			</div>
			<div class="buttons">
				<form action="restaurant_panel.php"><input type="submit" value="Panel lokalu"/></form>
			</div>
			<div class="buttons">
				<form action="complaint_panel.php"><input type="submit" value="Reklamacje"/></form>
			</div>
			
		</header>
		
		<article>
			
		<!---zostawiłem opcje z wpisywaniem wcześniej wpisanych danych, ale na razie nie ma tutaj możliwości nieprzejścia walidacji - może przydać się później, a w razie czego zawsze można to szybko usunąć--->
		<div class="form">
			<form method="post" action="restaurant_data_change.php">
				
				Nazwa lokalu: <br /> <input type="text" value="<?php
					if(isset($_SESSION['given_restaurantname']))
					{
						echo $_SESSION['given_restaurantname'];
						unset($_SESSION['given_restaurantname']);
					}
					else echo $your_restaurant['name'];
				
				?>" name="restaurantname" required/><br />
				
				<?php
				if (isset($_SESSION['e_restaurantname']))
				{
					echo '<div class="error">'.$_SESSION['e_restaurantname'].'</div>';
					unset($_SESSION['e_restaurantname']);
				}
				?>
				
				Opis lokalu:<br /> <textarea type="text" class="description" name="description"><?php
					if(isset($_SESSION['given_description']))
					{
						echo $_SESSION['given_description'];
						unset($_SESSION['given_description']);
					}
					else echo $your_restaurant['description'];
				
				?></textarea><br />
				
				<?php
				if (isset($_SESSION['e_description']))
				{
					echo '<div class="error">'.$_SESSION['e_description'].'</div>';
					unset($_SESSION['e_description']);
				}
				?>
				
				Region lokalu: <br />
				<select name="region">
				<?php
					if(isset($_SESSION['given_region']))
					{
						echo '<option>'.$_SESSION['given_region'].'</option>';
						unset($_SESSION['given_region']);
					}
					else
					{
						$your_regionQuery = $connection->query('SELECT name FROM regions WHERE id LIKE"'.$your_restaurant['id_region'].'"');
						$your_region = $your_regionQuery->fetch();
						echo '<option>'.$your_region['name'].'</option>';
					}
					
					foreach ($Qregions as $Qregion) 
					{
						echo "<option>{$Qregion['name']}</option>";
					}
				?>
				</select>
				
				<?php
				if (isset($_SESSION['e_region']))
				{
					echo '<div class="error">'.$_SESSION['e_region'].'</div>';
					unset($_SESSION['e_region']);
				}
				?>			
				
				<br /><br />
				<input type="submit" value="Zmień dane"/>			
			</form>
		</div>
			
		</article>
	
	</body>

</html>
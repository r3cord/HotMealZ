<?php

session_start();
if(isset($_SESSION['logged_id_partner']) == false)
{
	header('Location: index.php');
	exit();
}

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
				<form action="index.php"><input type="submit" value="Bieżące zamówienia"/></form>
			</div>
			<div class="buttons">
				<form action="complaint_panel.php"><input type="submit" value="Reklamacje"/></form>
			</div>
			
		</header>
		
		<article>
			
			<div class="button">
				<form action="restaurant_data_changeform.php"><input type="submit" value="Zmień dane lokalu"/></form>
			</div>
			
			<div class="button">
				<form action="restaurant_offer_changeform.php"><input type="submit" value="Zmień ofertę lokalu"/></form>
			</div>
			
			</br>
			<form method="post" action="discount.php">
			Procent przeceny: <br /> <input type="number" step="1" min="0" max="80" name="percentage" required/><input type="submit" value="Przeceń"/><br />
			</form>
			
			</br>
			<form action="discount_end.php">
			<input type="submit" value="Skończ przecenę"/><br />
			</form>
			
			<?php
				if (isset($_SESSION['e_discount']))
				{
					echo '<div class="error">'.$_SESSION['e_discount'].'</div>';
					unset($_SESSION['e_discount']);
				}
			?>
			
		</article>
	
	</body>

</html>
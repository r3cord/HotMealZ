<?php

session_start();

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

			<a href="index.php"><h1>HotMealZ</h1></a>

		
		<div class="button">
			<?php
			if(isset($_SESSION['logged_id']))
			{
				echo '<form action="logout.php"><input type="submit" value="Wyloguj się"/></form>';
			}
			else
			{
				echo '<form action="loginform.php"><input type="submit" value="Zaloguj się!"/></form>';
			}
			?>
		</div>
		
		<div class="button">
			<?php
			if(isset($_SESSION['logged_id']))
			{
				echo '<form action="index.php"><input type="submit" value="Panel"/></form>';
			}
			else
			{
				echo '<form action="registerform.php"><input type="submit" value="Zarejestruj się"/></form>';
			}
			?>
		</div>
	</header>
	
	<article>
		
	</article>
	
	</body>

</html>
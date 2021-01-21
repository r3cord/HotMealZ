<?php

session_start();
if(isset($_SESSION['logged_id_admin']) == false)
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

			<a href="admin_panel.php"><h1>HotMealZ</h1></a>

			
			<div class="button">
				<form action="logout_admin.php"><input type="submit" value="Wyloguj się"/></form>
			</div>
			
		</header>
		
		<article>
			
			<div class="button">
				<form action="registerform_admin.php"><input type="submit" value="Dodaj konto administratora"/></form>
			</div>
			
			<div class="button">
				<form action="registerform_deliverer.php"><input type="submit" value="Dodaj konto dostawcy"/></form>
			</div>
			
			<div class="button">
				<form action="deliverers_management.php"><input type="submit" value="Zarządzaj dostawcami"/></form>
			</div>
			
			<div class="button">
				<form action="accounts_management.php"><input type="submit" value="Zarządzaj kontami"/></form>
			</div>
			
			<div class="button">
				<form action="admin_panel.php"><input type="submit" value="Zarządzaj ofertami"/></form>
			</div>
			
			<?php
			//wypisanie ewentualnego komunikatu o powodzeniu rejestracji dostawcy
			if(isset($_SESSION['deliverer_registered']))
			{
				echo "</br></br>Konto dostawcy zostało dodane!";
				unset($_SESSION['deliverer_registered']);
			}
			else if(isset($_SESSION['admin_registered']))
			{
				echo "</br></br>Konto administratora zostało dodane!";
				unset($_SESSION['admin_registered']);
			}
			?>
			
		</article>
	
	</body>

</html>
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

		<div class="logo">
			<a href="admin_panel.php"><h1>HotMealZ</h1></a>
		</div>
		
		<div class="buttons">
		<form action="logout_admin.php"><input type="submit" value="Wyloguj się"/></form>
		</div>
			
		<div class="buttons">
		<form action="offer_management.php"><input type="submit" value="Powrót do listy wszystkich lokali"/></form>
		</div>
		
	</header>
	
	<article>
	
	<!---formularz na wpisanie szukanych danych przekierowujący do strony z wynikami--->
		<div class="form">
			<h1>Szukaj lokalu</h1>
			</br>
			<form method="post" action="admin_offer_search_result.php">
			
				Nazwa lokalu: <br /> <input type="text"  name="name"><br /><br />
				
				<input type="submit" value="Szukaj"/>			
			</form>			
			<br />
		</div>
		
	</article>
	
	</body>

</html>
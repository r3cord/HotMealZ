<?php

session_start();
if(isset($_SESSION['logged_id_partner']) == false)
{
	header('Location: index.php');
	exit();
}

require_once 'connect.php';
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
				<form action="logout_partner.php"><input type="submit" value="Wyloguj się"/></form>
			</div>
			
			<div class="button">
				<form action="restaurant_offer_changeform.php"><input type="submit" value="Powrót do zmiany oferty"/></form>
			</div>
			
		</header>
		
		<article>
			
		<!---zostawiłem opcje z wpisywaniem wcześniej wpisanych danych, ale na razie nie ma tutaj możliwości nieprzejścia walidacji - może przydać się później, a w razie czego zawsze można to szybko usunąć--->
		<div class="form">
			<form method="post" action="restaurant_offer_add.php">
				
				<!---pole na wpisanie nazwy dodawanego dania--->
				Nazwa dania: <br /> <input type="text" value="<?php
					if(isset($_SESSION['given_dishname']))
					{
						echo $_SESSION['given_dishname'];
						unset($_SESSION['given_dishname']);
					}
				?>" name="dishname" required/><br />
				
				<?php
				if (isset($_SESSION['e_dishname']))
				{
					echo '<div class="error">'.$_SESSION['e_dishname'].'</div>';
					unset($_SESSION['e_dishname']);
				}
				?>
				
				<!---pole na wpisanie ceny dodawanego dania--->
				Cena dania [zł]: <br /> <input type="number" step="0.01" value="<?php
					if(isset($_SESSION['given_price']))
					{
						echo $_SESSION['given_price'];
						unset($_SESSION['given_price']);
					}
				?>" name="price" required/><br />
				
				<?php
				if (isset($_SESSION['e_price']))
				{
					echo '<div class="error">'.$_SESSION['e_price'].'</div>';
					unset($_SESSION['e_price']);
				}
				?>
				
				<!---pole na wpisanie opisu dodawanego dania--->
				Opis dania:<br /> <input type="text" size="85" value="<?php
					if(isset($_SESSION['given_description']))
					{
						echo $_SESSION['given_description'];
						unset($_SESSION['given_description']);
					}
				?>" name="description" /><br />
				
				<?php
				if (isset($_SESSION['e_description']))
				{
					echo '<div class="error">'.$_SESSION['e_description'].'</div>';
					unset($_SESSION['e_description']);
				}
				?>		
				
				<br />
				<input type="submit" value="Dodaj danie"/>			
			</form>
		</div>
			
		</article>
	
	</body>

</html>
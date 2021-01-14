<?php
session_start();

if(isset($_SESSION['logged_id_partner']))
{
	if(isset($_GET['name']))
	{
		//poprzypisywanie zmiennych w celu uniknięcia if'a w każdym polu formularza
		$_SESSION['given_dishname'] = $_GET['name'];
		$_SESSION['given_price'] = $_GET['price'];
		$_SESSION['given_description'] = $_GET['description'];
		$_SESSION['id_edit'] = $_GET['id'];
		
		unset($_GET['id']);
		unset($_GET['name']);
		unset($_GET['price']);
		unset($_GET['description']);
	}
	else if(isset($_SESSION['given_dishname']))
	{
		;
	}
	else
	{
		header('Location: restaurant_offer_changeform.php');
		exit();
	}
}
else
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

			<a href="index.php"><h1>HotMealZ</h1></a>

			
			<div class="button">
				<form action="logout_partner.php"><input type="submit" value="Wyloguj się"/></form>
			</div>
			
			<div class="button">
				<form action="restaurant_offer_changeform.php"><input type="submit" value="Powrót do zmiany oferty"/></form>
			</div>
			
		</header>
		
		<article>

		<div class="form">
			<form method="get" <?php echo "action='dish_edit.php?id=".$_SESSION['id_edit']."'" ?>>
				
				<input type="hidden" name="id" value=<?=$_SESSION['id_edit'];?>>
				
				<!---pole na wpisanie nazwy dodawanego dania--->
				Nazwa dania: <br /> <input type="text" value="<?php
						echo $_SESSION['given_dishname'];
				?>" name="dishname" required/><br />
				
				<!---wypisanie ewentualnego komunikatu błędu--->
				<?php
				if (isset($_SESSION['e_dishname']))
				{
					echo '<div class="error">'.$_SESSION['e_dishname'].'</div>';
					unset($_SESSION['e_dishname']);
				}
				?>
				
				<!---pole na wpisanie ceny dodawanego dania--->
				Cena dania [zł]: <br /> <input type="number" step="0.01" min="0" value="<?php
						echo $_SESSION['given_price'];
				?>" name="price" required/><br />
				
				<!---wypisanie ewentualnego komunikatu błędu--->
				<?php
				if (isset($_SESSION['e_price']))
				{
					echo '<div class="error">'.$_SESSION['e_price'].'</div>';
					unset($_SESSION['e_price']);
				}
				?>
				
				<!---pole na wpisanie opisu dodawanego dania--->
				Opis dania:<br /> <textarea type="text" class="description" name="description"><?php
						echo $_SESSION['given_description'];
				?></textarea><br />
				
				<!---wypisanie ewentualnego komunikatu błędu--->
				<?php
				if (isset($_SESSION['e_description']))
				{
					echo '<div class="error">'.$_SESSION['e_description'].'</div>';
					unset($_SESSION['e_description']);
				}
				?>		
				
				<br />
				<input type="submit" value="Edytuj"/>			
			</form>
		</div>
			
		</article>
	
	</body>
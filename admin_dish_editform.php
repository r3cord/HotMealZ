<?php
session_start();

if(isset($_SESSION['logged_id_admin']))
{
	if(isset($_GET['name']))
	{
		//poprzypisywanie zmiennych w celu uniknięcia if'a w każdym polu formularza
		$_SESSION['given_dishname'] = $_GET['name'];
		$_SESSION['given_price'] = $_GET['price'];
		$_SESSION['given_description'] = $_GET['description'];
		$_SESSION['id_edit'] = $_GET['id'];
		$_SESSION['restaurant_id'] = $_GET['restaurant_id'];
		
		unset($_GET['id']);
		unset($_GET['name']);
		unset($_GET['price']);
		unset($_GET['description']);
		unset($_GET['restaurant_id']);
	}
	else if(isset($_SESSION['given_dishname']))
	{
		;
	}
	else
	{
		header('Location: offer_management.php');
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

			<div class="logo">
				<a href="admin_panel.php"><h1>HotMealZ</h1></a>
			</div>
			
			<div class="buttons">
				<form action="logout_admin.php"><input type="submit" value="Wyloguj się"/></form>
			</div>
			
			<div class="buttons">
				<form action="restaurant_offer_changeform.php"><input type="submit" value="Powrót do zmiany oferty"/></form>
			</div>
			<div class="buttons">
				<form action="admin_panel.php"><input type="submit" value="Powrót do panelu admina"/></form>
			</div>
			<div class="buttons">
				<form action="offer_management.php"><input type="submit" value="Powrót do listy wszystkich lokali"/></form>
			</div>
			
		</header>
		
		<article>

		<div class="form">
			<form method="get" <?php echo "action='admin_dish_edit.php?id=".$_SESSION['id_edit']."'" ?>>
				
				<!---zmienne niewidoczne potrzebne do usunięcia dania i późniejszego przekierowania do oferty wybranej restauracji--->
				<input type="hidden" name="id" value=<?=$_SESSION['id_edit'];?>>
				<input type="hidden" name="restaurant_id" value=<?=$_SESSION['restaurant_id'];?>>
				
				<!---pole na wpisanie nazwy dodawanego dania--->
				Nazwa dania: <br /> <input type="text" value="<?php
						echo $_SESSION['given_dishname'];
						unset($_SESSION['given_dishname']);
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
				Cena dania [zł]: <br /> <input type="number" value="<?php
						echo $_SESSION['given_price'];
						unset($_SESSION['given_price']);
				?>" name="price" disabled><br />
				
				<!---pole na wpisanie opisu dodawanego dania--->
				Opis dania:<br /> <textarea type="text" class="description" name="description"><?php
						echo $_SESSION['given_description'];
						unset($_SESSION['given_description']);
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
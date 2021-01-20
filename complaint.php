<?php
session_start();
if(!(isset($_POST['id_order']) && isset($_POST['restaurant_name']) && isset($_POST['id_restaurant']) && isset($_POST['order_date']) && isset($_POST['price']))) //Sprawdzenie, czy wymagane dane są ustawione
{
	header('Location: index.php');
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
				<form action="logout.php"><input type="submit" value="Wyloguj się"/></form>
			</div>
			<div class="buttons">
				<form action="panel.php"><input type="submit" value="Panel"/></form>
			</div>
			<div class="buttons">
				<form action="cart.php"><input type="submit" value="Koszyk"/></form>
			</div>
			
		</header>
		
		<article>
		<div class="list" style="max-width:800px;min-width:400px;">
			<!-- Wypisanie informacji o składanej reklamacji -->
			<h1>Reklamacja</h1>
			<?php echo "<p>Reklamacja do zamówienia z restauracji: ".$_POST['restaurant_name']."</p>";?>
			<?php echo "<p>Zamówione dnia: ".$_POST['order_date']." za: ".$_POST['price']." zł</p>";?>
			<h3>Opisz swój problem:</h3>
			<form action="submit_complaint.php" method="post">
			<textarea type="text" class="description" name="complaint" style="width: 400px; max-width:100%; min-width:400px; min-height:200px;"></textarea><br /><br />
			<input type="submit" value="Złóż reklamację"/><input type="hidden" value="<?php echo $_POST['id_order'];?>" name="id_order"/><input type="hidden" value="<?php echo $_POST['id_restaurant'];?>" name="id_restaurant"/>
			</form>

		</div>
		</article>
	
	</body>

</html>
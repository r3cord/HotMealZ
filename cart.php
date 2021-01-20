<?php
session_start();

if(!isset($_SESSION['logged_id'])) //Na tę stronę może wejść tylko użytkownik
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
		
		<script src="getValueFromCell.js"></script>


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
			<div class="list" >
				<h1>Koszyk:</h1>			
					<?php 
						if(isset($_SESSION['cart']) && isset($_SESSION['cart'][0])) //Sprawdzenie czy koszyk jest pusty
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
							//Wypisanie całej zawartości koszyka
							for($i=0; $i<$count; $i++)
							{
								echo "<tr>";
									echo "<td>" . $array[$i][2] . "</td>";
									echo "<td><form method='post' action='update_quantity.php'><input class='quantity' type='number' step='1' min='1' max='999' name='quantity' value='".$array[$i][3]."' required /><input type='submit' value='Aktualizuj' /><input type='hidden' value='".$i."' name='row' /><input type='hidden' name='rest_name' value='cart.php'/></form></td>";		
									echo "<td>" . $array[$i][4] . "zł</td>";		
									echo "<td>" . $array[$i][5] . "zł</td>";												
									echo "<td><form method='post' action='delete_dish_from_cart.php'><input type='submit' value='Usuń' /><input type='hidden' value='".$i."' name='row' /><input type='hidden' name='rest_name' value='cart.php'/></form></td>";
									
								echo "</tr>";
								$sum=$sum+$array[$i][5];
							}
							echo "</tbody>	
				                    </table>
									<h3>Suma: ".$sum." zł</h3>
									<form method ='post' action='delete_cart.php'><input type='submit' value='Opróżnij koszyk' /><input type='hidden' name='rest_name' value='cart.php'/></form></br>
									Dodaj uwagi do zamówienia:
									<form method ='post' action='submit_order.php'><textarea type='text' class='description' name='comments'></textarea></br>
									<input type='submit' value='Złóż zamówienie' /><input type='hidden' value='".$sum."' name='sum' /></form>";
						}
						else echo "Koszyk jest pusty";
					?>
			</div>

		</article>
	
	</body>

</html>
<?php
session_start();
if(!isset($_SESSION['logged_id_partner'])) //Sprawdzenie, czy osoba, która chce wejść na panel jest partnerem
{
	header('Location: index.php');
}
require_once 'connect.php';
//Pobranie odpowiednich danych takich jak id restauracji oraz informacji o reklamacji
$restaurantQuery = $connection->query('SELECT id FROM restaurants WHERE id_partner='.$_SESSION['logged_id_partner']);
$id_restaurant = $restaurantQuery->fetch();
$complaintsQuery = $connection->query('SELECT * FROM reclamations WHERE id_restaurant='.$id_restaurant['id'].' AND status="W trakcie rozpatrywania" ORDER BY id DESC');
$complaints = $complaintsQuery->fetchAll();
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
		<div class="list" style="min-width:300px;">
			<h1>Reklamacje do rozpatrzenia</h1></br>
			<?php
			if(isset($_SESSION['complaint_status'])) //Informacja zwrotna po zmianie statusu
			{
				echo "<p>".$_SESSION['complaint_status']."</p>";
				unset($_SESSION['complaint_status']);
			}
			if($complaintsQuery ->rowCount()>0) //Sprawdzenie, czy partner ma jakieś reklamacje do rozpatrzenia
			{
				echo "<table class='fixed_complaint'>
						   <thead>
								 <tr class='selectedRow'>
									<td>Data zamówienia</td>
									<td>Data dostarczenia</td>
									<td>Dania</td>
									<td>Kwota</td>
									<td>Opis problemu</td>
									<td>Rozpatrz</td>
								 </tr>
						   </thead>";
				foreach ($complaints as $complaint) 
				{
					$orderQuery = $connection->query('SELECT price, order_date, delivery_date FROM orders WHERE id='.$complaint['id_order']); //Pobranie informacji o zamówieniu, na które została złożona reklamacja
					$order = $orderQuery->fetch();
					echo "<tbody>";
					echo "<tr>";
					echo "<td>".$order['order_date']."</td>";						
								if($order['delivery_date']!=null)
								{
									echo "<td>".$order['delivery_date']."</td>";
								}
								else
								{
									echo "<td>Niedostarczone</td>";
								}
					//Pobranie informacji o zamówionych daniach, na które została złożona reklamacja
					$dishes_listQuery = $connection->query('SELECT id_dish, amount FROM od_connections WHERE id_order LIKE "'.$complaint['id_order'].'"');
					$dishes_list = $dishes_listQuery->fetchAll();
					echo "<td>";
					foreach ($dishes_list as $dish) //Wypisanie wszystkich dań i informacji o nich
					{
						$dishesQuery = $connection->query('SELECT name FROM dishes WHERE id LIKE "'.$dish['id_dish'].'"');
						$dish_name = $dishesQuery->fetch();
						echo $dish['amount']." razy ".$dish_name['name']."</br>";
					}
					echo "</td>";
					echo "<td>".$order['price']." zł</td>";	
					echo "<td>".$complaint['content']."</td>";
					echo "<td>
					<form method='post' action='change_complaint_status.php'>
					<select name='status'>
						<option>".$complaint['status']."</oprion>
						<option>Rozpatrzona pozytywnie</oprion>
						<option>Rozpatrzona negatywnie</oprion>
					</select>
					<input type='submit' value='Rozpatrz' /><input type='hidden' value='".$complaint['id']."' name='id_complaint'/>
					</form>
					</td>";
				}
			}
			else
			{
				echo "Nie posiadasz żadnych reklamacji!";
			}
			?>
		</div>
		</article>
	
	</body>

</html>
<?php
session_start();
if(!isset($_SESSION['logged_id']))
{
	header('Location: index.php');
}
require_once 'connect.php';
//Pobranie odpowiednich danych dotyczących złożonych zamówień
$ordersQuery = $connection->query('SELECT * FROM orders WHERE id_user='.$_SESSION['logged_id'].' ORDER BY order_date DESC');
$orders = $ordersQuery->fetchAll();
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
		<div class="list" style="min-width:300px;">
			<h1>Twoje zamówienia</h1>
			<?php
			if(isset($_SESSION['complaint_success'])) //Informacja zwrotna po złożeniu reklamacji
			{
				echo "<p>".$_SESSION['complaint_success']."</p>";
				unset($_SESSION['complaint_success']);
			}
			if(isset($_SESSION['order_success'])) //Informacja zwrotna po złożeniu zamówienia
			{
				echo "<p>".$_SESSION['order_success']."</p>";
				unset($_SESSION['order_success']);
			}
			$date = date("Y-m-d H:i:s");
			if($ordersQuery->rowCount()>0) //Sprawdzenie, czy użytkownik ma jakieś zamówienia
			{
				echo "<table class='fixed_orders'>
						   <thead>
								 <tr class='selectedRow'>
									<td>Data zamówienia</td>
									<td>Data data dostarczenia</td>
									<td>Restauracja</td>
									<td>Dania</td>
									<td>Kwota</td>
									<td>Status</td>
									<td>Reklamacja</td>
								 </tr>
						   </thead>";
				foreach ($orders as $order)  //Wypisanie wszystkich złożonych zamówień przez użytkownika
				{
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
					//Pobranie nazwy restauracji
					$restaurantQuery = $connection->query('SELECT name FROM restaurants WHERE id='.$order['id_restaurant']);
					$restaurant = $restaurantQuery->fetch();
					echo"<td>".$restaurant['name']."</td>";
					//Pobranie dań zamówionych w konkretnym zamówieniu
					$dishes_listQuery = $connection->query('SELECT * FROM od_connections WHERE id_order LIKE "'.$order['id'].'"');
					$dishes_list = $dishes_listQuery->fetchAll();
					echo "<td>";
					//Wypisanie dań
					foreach ($dishes_list as $dish)
					{
						$dishesQuery = $connection->query('SELECT name FROM dishes WHERE id LIKE "'.$dish['id_dish'].'"');
						$dish_name = $dishesQuery->fetch();
						echo $dish['amount']." razy ".$dish_name['name']."</br>";
					}
					echo "</td>";
					echo "<td>".$order['price']." zł</td>";	
					echo "<td>".$order['status']."</td>";
					//Pobranie statusu reklamacji
					$complaintQuery = $connection->query('SELECT status FROM reclamations WHERE id_order='.$order['id']);
					if($complaintQuery->rowCount()>0) //Sprawdzenie, czy reklamacja dla danego zamówienia istnieje i czy jest możliwa
					{
						$status = $complaintQuery->fetch();
						echo "<td>".$status['status']."</td>";
					}
					else if($date>$order['max_complaint_date'])
					{
						echo "<td>Wygasła</td>";
					}
					else if($order['delivery_date']==null)
					{
						echo "<td>Niemożliwa</td>";
					}
					else 
					{
						echo "<td><form method='post' action='complaint.php'><input type='submit' value='Zareklamuj'/><input type='hidden' value='".$order['id']."' name='id_order'/><input type='hidden' value='".$restaurant['name']."' name='restaurant_name'/><input type='hidden' value='".$order['order_date']."' name='order_date'/><input type='hidden' value='".$order['price']."' name='price'/><input type='hidden' value='".$order['id_restaurant']."' name='id_restaurant'/></form></td>";
					}
					echo "<tr>";
					echo "</tbody>";			
				}
			}
			else
			{
				echo "Nie posiadasz żadnych zamówień!";
			}
			?>
		</div>
		</article>
	
	</body>

</html>
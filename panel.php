<?php
session_start();
if(!isset($_SESSION['logged_id']))
{
	header('Location: index.php');
}
require_once 'connect.php';
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
				<?php
				echo '<form action="logout.php"><input type="submit" value="Wyloguj się"/></form>';
				?>
			</div>
			<div class="buttons">
				<?php
				echo '<form action="index.php"><input type="submit" value="Panel"/></form>';
				?>
			</div>
			<div class="buttons">
				<?php
				echo '<form action="cart.php"><input type="submit" value="Koszyk"/></form>';
				?>
			</div>
			
		</header>
		
		<article>
		<div class="list">
			<h1>Twoje zamówienia</h1>
			<?php
			$date = date("Y-m-d H:i:s");
			if($ordersQuery->rowCount()>0)
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
				foreach ($orders as $order) 
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
					$restaurantQuery = $connection->query('SELECT name FROM restaurants WHERE id='.$order['id_restaurant']);
					$restaurant = $restaurantQuery->fetch();
					echo"<td>".$restaurant['name']."</td>";
					$dishes_listQuery = $connection->query('SELECT * FROM od_connections WHERE id_order LIKE "'.$order['id'].'"');
					$dishes_list = $dishes_listQuery->fetchAll();
					echo "<td>";
					foreach ($dishes_list as $dish)
					{
						$dishesQuery = $connection->query('SELECT name FROM dishes WHERE id LIKE "'.$dish['id_dish'].'"');
						$dish_name = $dishesQuery->fetch();
						echo $dish['amount']." razy ".$dish_name['name']."</br>";
					}
					echo "</td>";
					echo "<td>".$order['price']." zł</td>";	
					echo "<td>".$order['status']."</td>";
					if($date>$order['max_complaint_date'])
					{
						echo "<td>Wygasła</td>";
					}
					else 
					{
						echo "<td><form method='post' action='complaint.php'><input type='submit' value='Zareklamuj'></form></td>";
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
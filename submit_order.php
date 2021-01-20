<?php
session_start();
if(isset($_POST['comments']) && isset($_POST['sum']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][0]) && isset($_SESSION['logged_id'])) //Sprawdzenie czy wymagane zmienne są ustalone
{
	$count = count($_SESSION['cart']); //Sprawdzenie ile wierszy ma tablica koszyka (ile dań)
	require_once 'connect.php';
	$null = null;
	$date = date("Y-m-d H:i:s"); //Pobranie aktualnej daty
	//Przygotowanie i wykonanie odpowiedniego zapytania do bazy MySQL (wstawienie zamówienia do tabeli orders)
	$addOrderQuery = $connection->prepare('INSERT INTO orders VALUES (NULL, :restaurant_id, :user_id, :deliverer_id, "w trakcie przygotowania", :price, :date, :deliverydate, now()+INTERVAL 1 DAY, 0, :note)');
	$addOrderQuery->bindValue(':restaurant_id', $_SESSION['cart'][0][0], PDO::PARAM_INT);
	$addOrderQuery->bindValue(':user_id', $_SESSION['logged_id'], PDO::PARAM_INT);
	
	//znalezienie regionu, w którym jest lokal w celu znalezienia dostawców z tego regionu
	$restaurantQuery = $connection->query('SELECT id_region FROM restaurants WHERE id LIKE "'.$_SESSION['cart'][0][0].'"');
	$restaurantQ = $restaurantQuery->fetch();
	//pobranie z bazy danych informacji o dostawcach z regionu, w którym jest restauracja wykonująca zamówienie o zmienianym statusie w celu policzenia, który dostawca ma najmniej aktualnych zamówień (ten dostanie nowe zamówienie)
	$deliverersQuery = $connection->query('SELECT * FROM deliverers WHERE id_region LIKE "'.$restaurantQ['id_region'].'"');
	$deliverers = $deliverersQuery->fetchAll();
	//znalezienie dostawcy z najmniejszą liczbą aktualnych zamówień
	$min = 99999;
	$min_id = -1;
	foreach ($deliverers as $del)
	{
		$delQuery = $connection->query('SELECT id FROM orders WHERE id_deliverer LIKE "'.$del['id'].'" AND (status LIKE "w trakcie przygotowania" OR status LIKE "w trakcie dostawy" OR status LIKE "oczekujące")');
		$a = $delQuery->rowCount();
		if ($a < $min) 
		{
			$min = $a;
			$min_id = $del['id'];
		}
	}
	$addOrderQuery->bindValue(':deliverer_id', $min_id, PDO::PARAM_INT);
	
	$addOrderQuery->bindValue(':price', $_POST['sum'], PDO::PARAM_STR);
	$addOrderQuery->bindValue(':date', $date, PDO::PARAM_STR);
	$addOrderQuery->bindValue(':deliverydate', $null, PDO::PARAM_NULL);
	$addOrderQuery->bindValue(':note', $_POST['comments'], PDO::PARAM_STR);
	$addOrderQuery->execute();
	$addOrderQuery = null;
	//Przygotowanie i wykonanie odpowiedniego zapytania do bazy MySQL (wyszukanie id dopiero co wstawionego rekordu do tabeli orders)
	$getOrderIdQuery = $connection->prepare('SELECT id FROM orders WHERE id_restaurant=:restaurant_id AND id_user=:user_id AND order_date=:date and note=:note');
	$getOrderIdQuery->bindValue(':restaurant_id', $_SESSION['cart'][0][0], PDO::PARAM_INT);
	$getOrderIdQuery->bindValue(':user_id', $_SESSION['logged_id'], PDO::PARAM_INT);
	//$getOrderIdQuery->bindValue(':price', $_POST['sum'], PDO::PARAM_STR);
	$getOrderIdQuery->bindValue(':date', $date, PDO::PARAM_STR);
	$getOrderIdQuery->bindValue(':note', $_POST['comments'], PDO::PARAM_STR);
	$getOrderIdQuery->execute();
	$order_id = $getOrderIdQuery->fetch();
	//$getOrderIdQuery=null;
	//Pętla wpisująca wszystkie dania do tabeli od_connections
	for($i=0; $i<$count; $i++)
	{
		$addOdConnection = $connection->prepare('INSERT INTO od_connections VALUES (NULL, :order_id, :dish_id, :amount)');
		$addOdConnection->bindValue(':order_id', $order_id['id'], PDO::PARAM_INT);
		$addOdConnection->bindValue(':dish_id', $_SESSION["cart"][$i][1], PDO::PARAM_INT);
		$addOdConnection->bindValue(':amount', $_SESSION["cart"][$i][3], PDO::PARAM_STR);
		$addOdConnection->execute();
		$addOdConnection = null;  
	}
	$_SESSION['order_success']="Twoje zamówienie zostało złożone do realizacji!"; //Ustawienie zmiennej sesyjnej, która będzie informacją zwrotną
	unset($_SESSION['cart']); //Usunięcie zawartości koszyka
	header('Location: panel.php'); //Powrót do index.php
	exit();

}
else
{
	header('Location: index.php'); //Powrót do index.php
	exit();
}

?>


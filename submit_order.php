<?php
session_start();
if(isset($_POST['comments']) && isset($_POST['sum']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][0]) && isset($_SESSION['logged_id'])) //Sprawdzenie czy wymagane zmienne są ustalone
{
	$count = count($_SESSION['cart']); //Sprawdzenie ile wierszy ma tablica koszyka (ile dań)
	require_once 'connect.php';
	$null = null;
	$date = date("Y-m-d H:i:s"); //Pobranie aktualnej daty
	//Przygotowanie i wykonanie odpowiedniego zapytania do bazy MySQL (wstawienie zamówienia do tabeli orders)
	$addOrderQuery = $connection->prepare('INSERT INTO orders VALUES (NULL, :restaurant_id, :user_id, 0, "w trakcie przygotowania", :price, :date, :deliverydate, now()+INTERVAL 1 DAY, 0, :note)');
	$addOrderQuery->bindValue(':restaurant_id', $_SESSION['cart'][0][0], PDO::PARAM_INT);
	$addOrderQuery->bindValue(':user_id', $_SESSION['logged_id'], PDO::PARAM_INT);
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


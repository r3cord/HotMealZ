<?php

session_start();
if(isset($_SESSION['logged_id_admin']) == false)
{
	header('Location: index.php');
	exit();
}

if(!isset($_GET['deliverer_id']))
{	
	header('Location: deliverers_management.php');
	exit();
}
else require_once 'connect.php';

$regionsQuery = $connection->query('SELECT id, name FROM regions');
$Qregions = $regionsQuery->fetchAll();

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
				<a href="admin_panel.php"><h1>HotMealZ</h1></a>
		</header>
			
		<article>
		
			<!---formularz z polem na wybranie nowego regionu dla dostawcy--->
			<!---dzięki przypisaniu wartości inputów typu "hidden" można potem zapisać komunikat dla admina--->
			<!---dzięki przypisaniu każdej opcji w <select> wartości id regionu nie trzeba potem pobierać po raz kolejny tych id z bazy danych--->
			<div class="form">
				<h1>Zmiana regionu dostawcy</h1>
				
				</br>
				<?="Zmieniasz region dostawcy ".$_GET['firstname']." ".$_GET['secondname']."</br>Aktualny region tego dostawcy: ".$_GET['region']?>
				</br></br>
				
					<form method="post" action="deliverer_region_change.php">
					<input type="hidden" name="deliverer_id" value=<?=$_GET['deliverer_id'];?>>
					<input type="hidden" name="firstname" value=<?=$_GET['firstname'];?>>
					<input type="hidden" name="secondname" value=<?=$_GET['secondname'];?>>
					
					Nowy region: <br />
					<select name="region_id">
					<?="<option value=".$_GET['region_id'].">".$_GET['region']." </option>";?>
					<option value="-1">NIEPRZYPISANY</option>
					<?php
						foreach ($Qregions as $Qregion) echo "<option value={$Qregion['id']}>{$Qregion['name']}</option>";
					?>
					</select>
					
						<br/><br/>
						<input type="submit" value="Zmień"/>					
					</form>
			</div>
		</article>
	</body>
</html>
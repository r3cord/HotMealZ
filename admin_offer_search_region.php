<?php
	
session_start();

if(isset($_SESSION['logged_id_admin']) == false)
{
	header('Location: index.php');
	exit();
}

require_once 'connect.php';

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

		<div class="logo">
			<a href="admin_panel.php"><h1>HotMealZ</h1></a>
		</div>
		
		<div class="buttons">
		<form action="logout_admin.php"><input type="submit" value="Wyloguj się"/></form>
		</div>
			
		<div class="buttons">
		<form action="offer_management.php"><input type="submit" value="Powrót do listy wszystkich lokali"/></form>
		</div>
		
	</header>
	
	<article>
	
		<!---formularz z wybieraniem regionu przekierowujący admina do strony z wynikami--->
		<div class="form">
				<h1>Wyszukaj lokale z regionu</h1>
				
					<form method="post" action="admin_offer_search_region_result.php">
					<select name="region_id">
					<?php
						foreach ($Qregions as $Qregion) echo "<option value={$Qregion['id']}>{$Qregion['name']}</option>";
					?>
					</select>
					<br/><br/>
					<input type="submit" value="Szukaj"/>					
					</form>
		
	</article>
	
	</body>

</html>
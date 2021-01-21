<?php

session_start();
if(isset($_SESSION['logged_id_admin']) == false)
{
	header('Location: index.php');
	exit();
}

if(!isset($_GET['user_id']))
{	
	header('Location: accounts_management.php');
	exit();
}
else require_once 'connect.php';

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
		
			<div class="form">
				<h1>Blokowanie konta użytkownika</h1>
				
				<!---informacja o tym, którego użytkownika blokuje admin--->
				</br>
				<?="Dajesz bana użytkownikowi ".$_GET['firstname']." ".$_GET['secondname']?>
				</br></br>
				
					<!---formularz na wpisanie daty wygaśnięcia bana--->
					<form method="post" action="ban.php">
					<input type="hidden" name="user_id" value=<?=$_GET['user_id'];?>>
					<input type="hidden" name="firstname" value=<?=$_GET['firstname'];?>>
					<input type="hidden" name="secondname" value=<?=$_GET['secondname'];?>>
					
					Data wygaśnięcia bana: <br />
					<input type="datetime-local" name="ban" required/>
					
						<br/><br/>
						<input type="submit" value="Zbanuj!"/>					
					</form>
			</div>
		</article>
	</body>
</html>
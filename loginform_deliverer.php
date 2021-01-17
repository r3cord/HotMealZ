<?php

session_start();

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
				<a href="index.php"><h1>HotMealZ</h1></a>
		</header>
			
		<article>
		
		<!---formularz do wpisywania danych logowania (e-mail i hasło)--->
			<div class="form">
				<h1>Zaloguj się jako dostawca!</h1>
				</br>
				<form method="post" action="login_deliverer.php">
					E-mail: <br /> <input type="email" value="<?php
					if (isset($_SESSION['given_email']))
					{
						echo $_SESSION['given_email'];
						unset($_SESSION['given_email']);
					}
					?>" name="email" required/><br />
							
					Hasło: <br /> <input type="password" name="password" required/><br />
					<?php
					//ewentualne wypisanie błędu przy wpisaniu błędnych danych
					if (isset($_SESSION['e_login']))
					{
						echo '<div class="error">'.$_SESSION['e_login'].'</div>';
						unset($_SESSION['e_login']);
					}
					?>
					</br>
					<input type="submit" value="Zaloguj się!"/>					
				</form>
			</div>
		</article>
	</body>
</html>
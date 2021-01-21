<?php
	
session_start();
if(isset($_SESSION['logged_id_admin']) == false)
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

	</head>
	<body>	
	<header>

		<a href="admin_panel.php"><h1>HotMealZ</h1></a>
		
	</header>
	
	<article>
	
		<!---formularz na wpisanie danych administratora--->
		<div class="form">
			<h1>Dodaj konto administratora</h1>
			</br>
			<form method="post" action="register_admin.php">
			
				E-mail: <br /> <input type="email" value="<?php
				if (isset($_SESSION['given_email']))
				{
					echo $_SESSION['given_email'];
					unset($_SESSION['given_email']);
				}
				?>" name="email" required/><br />
				
				<?php
				if (isset($_SESSION['e_email']))
				{
					echo '<div class="error">'.$_SESSION['e_email'].'</div>';
					unset($_SESSION['e_email']);
				}
				?>
				
				Hasło: <br /> <input type="password" name="password" required/><br />	
				Powtórz hasło: <br /> <input type="password" name="rpassword" required/><br />
				<?php
				if (isset($_SESSION['e_password']))
				{
					echo '<div class="error">'.$_SESSION['e_password'].'</div>';
					unset($_SESSION['e_password']);
				}
				?>
				
				<input type="submit" value="Dodaj administratora"/>			
			</form>
			
		</div>
		
	</article>
	
	</body>

</html>
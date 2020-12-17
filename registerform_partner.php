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
	
		<div class="form">
			<form method="post" action="register_partner.php">
			
				Imię: <br /> <input type="text" value="<?php
				if (isset($_SESSION['given_firstname']))
				{
					echo $_SESSION['given_firstname'];
					unset($_SESSION['given_firstname']);
				}
				?>" name="firstname" required/><br />
				
				<?php
				if (isset($_SESSION['e_firstname']))
				{
					echo '<div class="error">'.$_SESSION['e_firstname'].'</div>';
					unset($_SESSION['e_firstname']);
				}
				?>
				
				Nazwisko: <br /> <input type="text" value="<?php
				if (isset($_SESSION['given_secondname']))
				{
					echo $_SESSION['given_secondname'];
					unset($_SESSION['given_secondname']);
				}
				?>" name="secondname" required/><br />
				
				<?php
				if (isset($_SESSION['e_secondname']))
				{
					echo '<div class="error">'.$_SESSION['e_secondname'].'</div>';
					unset($_SESSION['e_secondname']);
				}
				?>
				
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
				
				<label>
				<input type="checkbox" name="rules" <?php
				if (isset($_SESSION['given_rules']))
				{
					echo "checked";
					unset($_SESSION['given_rules']);
				}
					?>/> Akceptuję regulamin
				</label><br />
				<?php
				if (isset($_SESSION['e_rules']))
				{
					echo '<div class="error">'.$_SESSION['e_rules'].'</div>';
					unset($_SESSION['e_rules']);
				}
				?>
				
				<input type="submit" value="Zarejestruj się!"/>			
			</form>
			
			<br />
			<form action="loginform_partner.php">
				Masz już konto?
				<input type="submit" value="Zaloguj się!"/>
			</form>
		</div>
		
	</article>
	
	</body>

</html>
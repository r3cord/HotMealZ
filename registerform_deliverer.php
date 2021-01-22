<?php
	
session_start();

if(isset($_SESSION['logged_id_admin']) == false)
{
	header('Location: index.php');
	exit();
}

require_once 'connect.php';
$regionsQuery = $connection->query('SELECT name FROM regions');
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
		<form action="admin_panel.php"><input type="submit" value="Powrót do panelu"/></form>
		</div>
		
	</header>
	
	<article>
	
	<!---formularz rejestracji z ewentualnym wyświetlaniem błędów--->
		<div class="form">
			<h1>Dodaj konto dostawcy</h1>
			</br>
			<form method="post" action="register_deliverer.php">
			
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
				
				Nr telefonu: <br /> <input type="phone" value="<?php
				if (isset($_SESSION['given_phone']))
				{
					echo $_SESSION['given_phone'];
					unset($_SESSION['given_phone']);
				}
				?>" name="phone" pattern="[0-9]{9}" required /><br />
				
				<?php
				if (isset($_SESSION['e_phone']))
				{
					echo '<div class="error">'.$_SESSION['e_phone'].'</div>';
					unset($_SESSION['e_phone']);
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
				
				Region dostawcy: <br />
				<select name="region">
				<?php
					if(isset($_SESSION['given_region']))
					{
						echo '<option>'.$_SESSION['given_region'].'</option>';
						unset($_SESSION['given_region']);
					}
				?>
				<option>=wybierz z listy=</option>
				<option>=na razie nie przypisuj=</option>
				<?php
					foreach ($Qregions as $Qregion) 
					{
						echo "<option>{$Qregion['name']}</option>";
					}
				?>
				</select>
				
				<?php
				if (isset($_SESSION['e_region']))
				{
					echo '<div class="error">'.$_SESSION['e_region'].'</div>';
					unset($_SESSION['e_region']);
				}
				?>
				
				<input type="submit" value="Dodaj konto dostawcy!"/>			
			</form>
			
			<br />
		</div>
		
	</article>
	
	</body>

</html>
<?php

session_start();

if(!isset($_SESSION['logged_id']))
{
	if(isset($_POST['email']))
	{
		$email=filter_input(INPUT_POST, 'email');
		$password=filter_input(INPUT_POST, 'password');
		
		require_once 'connect.php';
		$userQuery = $connection->prepare('SELECT id, password, ban FROM users WHERE email = :email');
		$userQuery->bindValue(':email', $email, PDO::PARAM_STR);
		$userQuery->execute();
		
		$user = $userQuery->fetch();
		
		//sprawdzenie czy użytkownik nie jest zbanowany
		if($user['ban'] > date('Y-m-d H:i:s'))
		{
			$_SESSION['e_login'] = "Twoje konto zostało zablokowane do ".$user['ban']."!";
			header('Location: loginform.php');
			exit();
		}
		
		if($user && password_verify($password, $user['password']))
		{
			$_SESSION['logged_id'] = $user['id'];
			unset($_SESSION['e_login']);
			header('Location: index.php');
			exit();
		}
		else
		{
			$_SESSION['e_login'] = "Podany email lub hasło są błędne!";
			header('Location: loginform.php');
			exit();
		}
	}
	else
	{
		header('Location: loginform.php');
		exit();
	}
}
else
{
	header('Location: index.php');
	exit();
}

<?php

session_start();

if(!isset($_SESSION['logged_id']))
{
	if(isset($_POST['email']))
	{
		$email=filter_input(INPUT_POST, 'email');
		$password=filter_input(INPUT_POST, 'password');
		
		require_once 'connect.php';
		$userQuery = $connection->prepare('SELECT id, password FROM users WHERE email = :email');
		$userQuery->bindValue(':email', $email, PDO::PARAM_STR);
		$userQuery->execute();
		
		$user = $userQuery->fetch();
		
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

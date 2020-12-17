<?php

session_start();

if(!isset($_SESSION['logged_id_partner']))
{
	if(isset($_POST['email']))
	{
		$email=filter_input(INPUT_POST, 'email');
		$password=filter_input(INPUT_POST, 'password');
		
		require_once 'connect.php';
		$partnerQuery = $connection->prepare('SELECT id, password FROM partners WHERE email = :email');
		$partnerQuery->bindValue(':email', $email, PDO::PARAM_STR);
		$partnerQuery->execute();
		
		$user = $partnerQuery->fetch();
		
		if($user && password_verify($password, $user['password']))
		{
			$_SESSION['logged_id_partner'] = $user['id'];
			unset($_SESSION['e_login']);
			header('Location: index.php');
			exit();
		}
		else
		{
			$_SESSION['e_login'] = "Podany email lub hasło są błędne!";
			header('Location: loginform_partner.php');
			exit();
		}
	}
	else
	{
		header('Location: loginform_partner.php');
		exit();
	}
}
else
{
	header('Location: index.php');
	exit();
}

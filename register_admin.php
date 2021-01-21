<?php

session_start();

if(isset($_POST['email']))
{
	$validation=true;
		
	$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
	if (empty($email)) 
	{	
		$validation=false;
		$_SESSION['e_email']="Prosimy podać poprawny e-mail!";
	} 
	
	$password=$_POST['password'];
	$rpassword=$_POST['rpassword'];
	if ((strlen($password)<8) || (strlen($password)>20))
	{
		$validation=false;
		$_SESSION['e_password']="Hasło musi posiadać od 8 do 20 znaków!";
	}
		
	if($password!=$rpassword)
	{
		$validation=false;
		$_SESSION['e_password']="Podane hasła nie są identyczne!";
	}
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);	
		
	if($validation)
	{
		require_once 'connect.php';
		
		$query = $connection->prepare('SELECT id FROM admins WHERE email = :email');
		$query->bindValue(':email', $email, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount()>0)
		{
			$validation=false;
			$_SESSION['e_email']="Już istnieje administrator o takim e-mailu!";
			$query=NULL;
		}
		else
		{
			$query = $connection->prepare('INSERT INTO admins VALUES (NULL, :email, :hashed_password)');
			$query->bindValue(':email', $email, PDO::PARAM_STR);
			$query->bindValue(':hashed_password', $hashed_password, PDO::PARAM_STR);
			$query->execute();
			$query=NULL;
			$_SESSION['admin_registered']=true;
			header('Location: admin_panel.php');
			exit();
		}
				
	}
		
	if(!$validation)
	{
		$_SESSION['given_email'] = $_POST['email'];
		header('Location: registerform_admin.php');
		exit();
	}
}
else
{
	header('Location: registerform_admin.php');
}
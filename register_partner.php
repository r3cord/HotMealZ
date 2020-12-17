<?php

session_start();

if(isset($_POST['email']))
{
	$validation=true;
		
	$firstname=$_POST['firstname'];
	if((strlen($firstname)<3) || (strlen($firstname)>20))
	{
		$validation=false;
		$_SESSION['e_firstname']="Imię musi posiadać od 3 do 20 znaków!";
	}
	if(!preg_match('/^[A-PR-UWY-ZĄĆĘŁŃÓŚŹŻ]*$/iu',$firstname))
	{
		$validation=false;
		$_SESSION['e_firstname']="Imię może się składać tylko z polskich znaków!";
	}
		
	$secondname=$_POST['secondname'];
	if((strlen($secondname)<3) || (strlen($secondname)>20))
	{
		$validation=false;
		$_SESSION['e_secondname']="Nazwisko musi posiadać od 3 do 20 znaków!";
	}
			
	if(!preg_match('/^[A-PR-UWY-ZĄĆĘŁŃÓŚŹŻ]*$/iu',$secondname))
	{
		$validation=false;
		$_SESSION['e_secondname']="Nazwisko może się składać tylko z polskich znaków!";
	}
	
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
		
	if (!isset($_POST['rules']))
	{
		$validation=false;
		$_SESSION['e_rules']="Potwierdź akceptację regulaminu!";
	}		
		
	if($validation)
	{
		require_once 'connect.php';
		
		$query = $connection->prepare('SELECT id FROM partners WHERE email = :email');
		$query->bindValue(':email', $email, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount()>0)
		{
			$validation=false;
			$_SESSION['e_email']="Już istnieje partner o takim e-mailu!";
			$query=NULL;
		}
		else
		{
			$query = $connection->prepare('INSERT INTO partners VALUES (NULL, :firstname, :secondname, :email, :hashed_password)');
			$query->bindValue(':firstname', $firstname, PDO::PARAM_STR);
			$query->bindValue(':secondname', $secondname, PDO::PARAM_STR);
			$query->bindValue(':email', $email, PDO::PARAM_STR);
			$query->bindValue(':hashed_password', $hashed_password, PDO::PARAM_STR);
			$query->execute();
			$query=NULL;
			$_SESSION['registered']=true;
			header('Location: loginform_partner.php');
			exit();
		}
				
	}
		
	if(!$validation)
	{
		$_SESSION['given_firstname'] = $_POST['firstname'];
		$_SESSION['given_secondname'] = $_POST['secondname'];
		$_SESSION['given_email'] = $_POST['email'];
		if (isset($_POST['rules'])) $_SESSION['given_rules'] = true;
		header('Location: registerform_partner.php');
		exit();
	}
}
else
{
	header('Location: registerform_partner.php');
}
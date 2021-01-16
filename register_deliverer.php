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
	
	$phone=$_POST['phone'];
	if(strlen($phone)!=9)
	{
		$validation=false;
		$_SESSION['e_phone']="Niepoprawny numer telefonu!";
	}
	
	$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
	if (empty($email)) 
	{	
		$validation=false;
		$_SESSION['e_email']="Niepoprawny e-mail!";
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
	

	$region=$_POST['region'];
	if ($region=='=wybierz z listy=')
	{
		$validation=false;
		$_SESSION['e_region']="Wybierz region!";
	}
		
		
		
	if($validation)
	{
		require_once 'connect.php';
		
		$query = $connection->prepare('SELECT id FROM deliverers WHERE email = :email');
		$query->bindValue(':email', $email, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount()>0)
		{
			$validation=false;
			$_SESSION['e_email']="Już istnieje dostawca o takim e-mailu!";
			$query=NULL;
		}
		else
		{
			if($region=='=na razie nie przypisuj=')
			{
				$id_region = -1;
			}
			else
			{
				$regionQuery = $connection->query('SELECT id FROM regions WHERE name LIKE "'.$region.'"');
				$_id_region = $regionQuery->fetch();
				$id_region = $_id_region['id'];
			}
			
			$query = $connection->prepare('INSERT INTO deliverers VALUES (NULL, :id_region, :firstname, :secondname, :email, :hashed_password, :phone)');
			$query->bindValue(':id_region', $id_region, PDO::PARAM_STR);
			$query->bindValue(':firstname', $firstname, PDO::PARAM_STR);
			$query->bindValue(':secondname', $secondname, PDO::PARAM_STR);
			$query->bindValue(':email', $email, PDO::PARAM_STR);
			$query->bindValue(':hashed_password', $hashed_password, PDO::PARAM_STR);
			$query->bindValue(':phone', $phone, PDO::PARAM_STR);
			$query->execute();
			
			$query=NULL;
			$_SESSION['deliverer_registered']=true;
			header('Location: admin_panel.php');
			exit();
		}
				
	}
		
	if(!$validation)
	{
		$_SESSION['given_firstname'] = $_POST['firstname'];
		$_SESSION['given_secondname'] = $_POST['secondname'];
		$_SESSION['given_phone'] = $_POST['phone'];
		$_SESSION['given_email'] = $_POST['email'];
		if($region!='=wybierz z listy=') $_SESSION['given_region'] = $_POST['region'];
		header('Location: registerform_deliverer.php');
		exit();
	}
}
else
{
	header('Location: registerform_deliverer.php');
}
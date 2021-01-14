<?php
session_start();
unset($_SESSION['cart']);
header('Location: dishes_list.php?rest='.$_POST['rest_name']);
exit();
?>


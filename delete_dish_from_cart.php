<?php
session_start();
array_splice($_SESSION['cart'], $_POST['row'], 1);
header('Location: dishes_list.php?rest='.$_POST['rest_name']);
exit();
?>


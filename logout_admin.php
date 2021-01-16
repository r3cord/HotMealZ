<?php

session_start();

unset($_SESSION['logged_id_admin']);
header('Location: index.php');
exit();

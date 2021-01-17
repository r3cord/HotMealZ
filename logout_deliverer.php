<?php

session_start();

unset($_SESSION['logged_id_deliverer']);
header('Location: index.php');
exit();

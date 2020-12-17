<?php

session_start();

unset($_SESSION['logged_id_partner']);
header('Location: index.php');
exit();

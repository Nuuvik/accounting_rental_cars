<?php

$host='localhost';
$login_bd='admin_rent';
$password_bd='kjT5vOuBljWj5xXu';
$dbname='rent';
$link = mysqli_connect($host, $login_bd, $password_bd, $dbname);
mysqli_query($link,'set names utf8');
mysqli_query($link,"SET CHARACTER SET 'utf8'");
mysqli_query($link,"SET SESSION vollation_connection = 'utf8_general_ci';");

?>
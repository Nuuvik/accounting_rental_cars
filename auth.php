<?php
session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Библиотека</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<meta charset="utf-8">
</head>
<body>
<?php
require_once 'menu.php';
 ?>
 <div class="d_cont">
   <?php
if(isset($_POST['login']))
{
  $login=$_POST['login'];
  if ($login=='')
  {
    unset($login);
  }
}

if(isset($_POST['password']))
{
  $password=$_POST['password'];
  if ($password=='')
  {
    unset($password);
  }
}
if(empty($login)or empty($password))
{
  exit("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
}
$login=stripslashes($login);
$login=htmlspecialchars($login);

$password=stripslashes($password);
$password=htmlspecialchars($password);

$login=trim($login);
$password=trim($password);
$password=md5($password);

require_once "login.php";

$result=mysqli_query($link,"SELECT * FROM users WHERE login='$login'");
$myrow=mysqli_fetch_array($result);
if (empty($myrow['password']))
{
  exit("Извините, введенный вами логин или пароль неверный.");
}
else
{
if ($myrow['password']==$password) {
  $_SESSION['id']=$myrow['id'];
  $_SESSION['login']=$myrow['iogin'];
  $_SESSION['status']=$myrow['status'];
  $_SESSION['login']=$login;
  echo "Добро пожаловать, ".$_SESSION['login']."! Вы успешно вошли сайт!";
  echo "<br>";
}
else
{
exit("Извините, введенный вами логин или пароль неверный.");
}
}
    ?>
 </div>
</body>
</html>

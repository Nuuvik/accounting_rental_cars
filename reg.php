<?php
session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Учет технических и материальных активов СПБГЛТУ</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<script type="text/javascript" src="js/script.js"></script>
<meta charset="utf-8">
<title>
</title>
</head>
<body>
<?php
require_once "menu.php";
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
$result=mysqli_query($link,"SELECT id FROM users WHERE login='$login'");
$myrow=mysqli_fetch_array($result);
if (!empty($myrow['id']))
{
  exit("Извините, введенный вами логин уже зарегистрирован. Введите другой логин.");
}

$result2=mysqli_query($link,"INSERT INTO users (login,password,status) VALUES ('$login','$password',10)");
if ($result2=='TRUE') {
echo "Вы успешно зарегистрированы! Теперь вы можете зайти на сайт.<a href='auth_form.php'>Войти на сайт</a>";
}
else {
 echo "Ошибка! Вы не зарегистрированы.";
}
    ?>
 </div>
</body>
</html>

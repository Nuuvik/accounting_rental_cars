<?php
session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Учет технических и материальных активов СПБГЛТУ</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<meta charset="utf-8">
<title>
</title>
</head>
<body>
<?php
require_once 'menu.php';
 ?>
 <div class="d_cont">
<?php
if (empty($_SESSION['login']) or empty($_SESSION['id']))
{
 ?>
    <form  action="auth.php" method="post">
   <h3>Авторизация</h3>
   <p>
<label>Ваш логин:<br></label>
<input name="login" type="text" size="15" maxlength="15">
     </p>
     <p>
       <label>Ваш пароль:<br></label>
       <input name="password" type="password" size="15" maxlength="15">
     </p>
     <input type="submit" name="submit" value="Войти">
   </form>
<?php
}
else {
echo 'Вы уже вошли как '.$_SESSION['login'].'.<a href="?exit">Выйти</a>';
}
 ?>
 </div>
</body>
</html>

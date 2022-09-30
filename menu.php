<div class ="banner_text">

<a href="index.php" class="text"><h1>Прокат автомобилей</h1></a>
  
  <div class="reg">
  <?php
    if (empty($_SESSION['login']) or empty($_SESSION['id']))
    {
        echo 'Добро пожаловать, Гость!';
        echo '<br>';
        echo '<a href="reg_form.php">Регистрация</a>/<a href="auth_form.php">Вход</a>';
    }
    else
    {
        echo 'Добро пожаловать, ' . $_SESSION['login'].'!';
        echo '<br>';
        echo '<a href="?exit">Выйти</a>';
    }
    if(isset($_GET['exit']))
    {
        session_unset();
        session_destroy();
        echo '<meta http-equiv="refresh" content="0;URL='.$_SERVER['PHP_SELF'].'">';
        exit;
    }
    ?>
    </div>
        </div>

 


  <ul class="menu">

<li><a href="#">Автомобили</a>
    <ul class="sub_menu">
        
        <li class="circle_angle"><a href="auto_list.php">Список всех автомобилей</a></li>
        
    </ul>

</li>

<li><a href="clients_list.php">Клиенты</a></li>

<li><a href="#">Прокат</a>
<ul class="sub_menu">
       
        <li class="circle_angle"><a href="rent_list.php">Информация о сдаче</a></li>
        
    </ul>
    </li>
    



<li><a href="search.php">Поиск информации по прокату</a></li>

</ul>

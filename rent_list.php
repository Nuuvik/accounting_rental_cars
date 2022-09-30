<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Прокат автомобилей "Варан СПб"</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script type="text/javascript" src="js/script.js"></script>
    <meta charset="UTF-8">
    </head>
    <body>

    <?php

    require_once "menu.php"; //подключение файла с баннером и главным меню
    require_once 'login.php'; //подключение к БД UCHET

    if (!isset($_GET["action"])) $_GET["action"] = "showlist"; // действие по умолчанию
    // цикл для выбора функции в зависимости от действий пользователя
    switch ( $_GET["action"])
    {
        case "showlist":                //список всех записей в таблице БД
            show_list($link); break;
        case "addform":                 //форма для добавления новой записи
            get_add_item_form(); break;
        case "add":                     //добавить новую запись в таблицу БД
            add_item(); break;
        case "editform":                //форма для редактирования записи
            get_edit_item_form(); break;
        case "update":                  //обновить запись в таблице БД
            update_item(); break; 
        case "delete":                  //удалить запись в таблице БД
            delete_item(); break;
        default:
            show_list($link);
    }

    function show_list($link) // функция выводит список всех записей в таблице БД
    {
        global $link;
        $query ='SELECT * FROM v_prokate';
        $res = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        echo '<div class="d_cont">';
        echo '<h2>Информация о прокате</h2>';
        echo '<button type="button" onClick="history.back();">Назад</button><br>';
        echo '<br><table border="1" class="data_tbl">';
        echo '<tr align="center"><th>ФИО клиента</th><th>Автомобиль</th><th>Дата начала аренды</th><th>Дата окончания аренды</th></tr>';
        if (empty($_SESSION['id']))
        {
        while ( $item = mysqli_fetch_array( $res ) )
        {
            echo '<tr align="center" class="tbl">';
            echo '<td>'.$item['fio_client'].'</td>';
            echo '<td>'.$item['marka'].'</td>';
            echo '<td>'.$item['date_rent'].'</td>';
            echo '<td>'.$item['date_end'].'</td>';
            
        }
    }
    elseif ($_SESSION['status'] == 1)
    {
        while ( $item = mysqli_fetch_array( $res ) )
        {
            echo '<tr align="center" class="tbl">';
            echo '<td>'.$item['fio_client'].'</td>';
            echo '<td>'.$item['marka'].'</td>';
            echo '<td>'.$item['date_rent'].'</td>';
            echo '<td>'.$item['date_end'].'</td>';
            echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=editform&id_prokat='.$item['id_prokat'].'"><img src="img/edit.png" title="Редактировать"></a></td>';
            echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=delete&id_prokat='.$item['id_prokat'].'"><img src="img/drop.png" title="Удалить" onClick="return confirmDelete();"></a></td>';
        }
        echo '<tr align="center"><td colspan=6>
        <a href="'.$_SERVER['PHP_SELF'].'?action=addform">
        <button type="button">Добавить</button></a>
        </td></tr>';
    }
    else 
    {
        while ( $item = mysqli_fetch_array( $res ) )
        {
            echo '<tr align="center" class="tbl">';
            echo '<td>'.$item['fio_client'].'</td>';
            echo '<td>'.$item['marka'].'</td>';
            echo '<td>'.$item['date_rent'].'</td>';
            echo '<td>'.$item['date_end'].'</td>';
             
        }
    }
        echo '</table>';
        echo '</div>';
    }

    function get_add_item_form(){
        if ($_SESSION['status'] == 1)
        {
    
    

        global $link;
        echo '<div class = "d_content">';
        echo '<h2>Добавить</h2>';
        echo '<form name ="addform" action="'.$_SERVER['PHP_SELF'].'?action=add" method="POST">';
        echo '<button type ="button" onClick="history.back();">Отменить</button><br />';
        echo '<br><table border="1" class="data_tbl">';

        echo '<tr>';
        echo '<td>ФИО клиента</td>';
        echo '<td>';
        $sql1 = "SELECT * FROM client";
        
        $res1 = mysqli_query($link, $sql1) or die ("Error in $sql1 : " . mysql_error());
        
        echo '<select name="id_client">\r\n';
        echo '<option selected disabled>Выберите клиента</option>';
        while($row = mysqli_fetch_array($res1))
        {
        $id_client = intval($row['id_client']);
        $fio_client = htmlspecialchars($row['fio_client']);
        echo "<option value='$id_client'>$fio_client</option>\r\n";
        }
        echo "</select>\r\n";
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Автомобиль</td>';
        echo '<td>';
        $sql1 = "SELECT * FROM auto";
        
        $res1 = mysqli_query($link, $sql1) or die ("Error in $sql1 : " . mysql_error());
        
        echo '<select name="id_auto">\r\n';
        echo '<option selected disabled>Выберите автомобиль</option>';
        while($row = mysqli_fetch_array($res1))
        {
        $id_auto = intval($row['id_auto']);
        $marka = htmlspecialchars($row['marka']);
        echo "<option value='$id_auto'>$marka</option>\r\n";
        }
        echo "</select>\r\n";
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Дата начала аренды</td>';
        echo '<td><input type="date" name="date_rent" value="" /></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Дата окончания аренды</td>';
        echo '<td><input type="date" name="date_end" value="" /></td>';
        echo '</tr>';
        
        echo '<tr align="center">';
        echo '<td colspan="2"><input type="submit" value="Сохранить"></td>';
        echo '</tr>';
        echo '</table>';
        echo '</form>';
        echo '</div>';
    }
    else
        {
            echo '<meta http-equiv="refresh" content="0;URL=rent_list.php">';
        }

        
        }


    function add_item()
        {
        global $link;
        $id_client = mysqli_escape_string($link, $_POST['id_client']);
        $id_auto = mysqli_escape_string($link, $_POST['id_auto']);
        $date_rent = mysqli_escape_string($link, $_POST['date_rent']);
        $date_end = mysqli_escape_string($link, $_POST['date_end']);
        
        $query = "INSERT INTO prokat (id_client, id_auto, date_rent, date_end) VALUES ('".$id_client."','".$id_auto."','".$date_rent."','".$date_end."' );";
        mysqli_query($link, $query) or die ("Ошибка " . mysqli_error($link));
        echo '<meta http-equiv="refresh" content="0;URL=rent_list.php">';
        die();
        }


// Функция формирует форму для редактирования записи в таблице БД 
function get_edit_item_form() 
{
    if ($_SESSION['status'] == 1)
    {

 
global $link;
  echo '<div class="d_cont">';
  echo '<h2>Редактировать</h2>'; 
  $query = 'SELECT * FROM v_prokate WHERE id_prokat='.$_GET['id_prokat']; 
  $res = mysqli_query( $link, $query ) or die("Ошибка " . mysqli_error($link)); 
  $item = mysqli_fetch_array( $res ); 
  echo '<form name="editform" action="'.$_SERVER['PHP_SELF'].'?action=update&id_prokat='.$_GET['id_prokat'].'" method="POST">'; 
  echo '<button type="button" onClick="history.back();">Отменить</button><br />';
  echo '<br><table border="1" class="data_tbl">'; 
  
  
  echo '<tr>'; 
  echo '<td>ФИО клиента</td>'; 
  echo '<td>'; 
  $sql4 = 'SELECT * FROM client'; 

  $res4 = mysqli_query($link,$sql4) or die( "Error in $sql4 : " . mysql_error());
  
  echo '<select name="id_client">\r\n';
  echo '<option selected value="'.(int)$item['id_client'].'">'.$item['fio_client'].'</option>';
  echo '<option disabled>------------------</option>';
  while($row = mysqli_fetch_array($res4)) 
  { 
      $id_client = intval($row['id_client']); 
      $fio_client = htmlspecialchars($row['fio_client']);
      echo "<option value=$id_client>$fio_client</option>\r\n"; 
  } 
  echo "</select>\r\n";
  echo '</td>';
  echo '</tr>';  

  echo '<tr>'; 
  echo '<td>Автомобиль</td>'; 
  echo '<td>'; 
  $sql4 = 'SELECT * FROM auto'; 

  $res4 = mysqli_query($link,$sql4) or die( "Error in $sql4 : " . mysql_error());
  
  echo '<select name="id_auto">\r\n';
  echo '<option selected value="'.(int)$item['id_auto'].'">'.$item['marka'].'</option>';
  echo '<option disabled>------------------</option>';
  while($row = mysqli_fetch_array($res4)) 
  { 
      $id_auto = intval($row['id_auto']); 
      $marka = htmlspecialchars($row['marka']);
      echo "<option value=$id_auto>$marka</option>\r\n"; 
  } 
  echo "</select>\r\n";
  echo '</td>';
  echo '</tr>';  

  echo '<tr>'; 
  echo '<td>Дата начала аренды</td>'; 
  echo '<td><input type="date" name="date_rent" value="'.$item['date_rent'].'"></td>'; 
  echo '</tr>';  
  echo '<tr>'; 
  echo '<td>Дата окончания аренды</td>'; 
  echo '<td><input type="date" name="date_end" value="'.$item['date_end'].'"></td>'; 
  echo '</tr>';  
  
  echo '<tr align="center">'; 
  echo '<td colspan=5><input type="submit" value="Сохранить"></td>'; 
  echo '</tr>'; 
  echo '</table>'; 
  echo '</form>'; 
  echo '</div>';
  echo '<br>';
}
else
    {
        echo '<meta http-equiv="refresh" content="0;URL=rent_list.php">';
    }

}

function update_item()
{
    global $link;
    $id_client = mysqli_escape_string($link, $_POST['id_client']);
        $id_auto = mysqli_escape_string($link, $_POST['id_auto']);
        $date_rent = mysqli_escape_string($link, $_POST['date_rent']);
        $date_end = mysqli_escape_string($link, $_POST['date_end']);
    $query = "UPDATE prokat SET id_client='".$id_client."',id_auto='".$id_auto."',date_rent='".$date_rent."',
    date_end='".$date_end."' WHERE id_prokat=".$_GET['id_prokat'];
    mysqli_query ( $link, $query ) or die("Ошибка" . mysqli_error($link));
   
    echo '<meta http-equiv="refresh" content="0;URL=rent_list.php">';
    die();

}

function delete_item(){
    if ($_SESSION['status'] == 1)
    {


    global $link;
    
    $query = "DELETE FROM prokat WHERE id_prokat=".$_GET['id_prokat'];
   
    mysqli_query ($link, $query) or die("Ошибка " . mysqli_error($link));
    echo '<meta http-equiv="refresh" content="0;URL=rent_list.php">';
    die();
}
else
    {
        echo '<meta http-equiv="refresh" content="0;URL=rent_list.php">';
    }

    
    }

    

?>
    
</body>
</html>
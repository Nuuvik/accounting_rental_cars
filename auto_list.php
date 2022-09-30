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

    require_once 'menu.php'; 
    require_once 'login.php'; 


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
        $query ='SELECT * FROM auto';
        $res = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        echo '<div class="d_cont">';
        echo '<h2>Информация об автомобилях</h2>';
        echo '<button type="button" onClick="history.back();">Назад</button><br>';
        echo '<br><table border="1" class="data_tbl">';
        echo '<tr align="center"><th>Марка</th><th>Тип кузова</th><th>Год</th><th>Стоимость в сутки (в рублях)</th><th>Залог (в рублях)</th></tr>';
        if (empty($_SESSION['id']))
        {
        while ( $item = mysqli_fetch_array( $res ) )
        {
            echo '<tr align="center" class="tbl">';
            echo '<td>'.$item['marka'].'</td>';
            echo '<td>'.$item['type'].'</td>';
            echo '<td>'.$item['year'].'</td>';
            echo '<td>'.$item['cost_per_day'].'</td>';
            echo '<td>'.$item['deposit'].'</td>';
        }
    }
    elseif ($_SESSION['status'] == 1)
    {
        while ( $item = mysqli_fetch_array( $res ) )
        {
            echo '<tr align="center" class="tbl">';
            echo '<td>'.$item['marka'].'</td>';
            echo '<td>'.$item['type'].'</td>';
            echo '<td>'.$item['year'].'</td>';
            echo '<td>'.$item['cost_per_day'].'</td>';
            echo '<td>'.$item['deposit'].'</td>';
            echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=editform&id_auto='.$item['id_auto'].'"><img src="img/edit.png" title="Редактировать"></a></td>';
            echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=delete&id_auto='.$item['id_auto'].'"><img src="img/drop.png" title="Удалить" onClick="return confirmDelete();"></a></td>';
        }
        echo '<tr align="center"><td colspan=7>
        <a href="'.$_SERVER['PHP_SELF'].'?action=addform">
        <button type="button">Добавить</button></a>
        </td></tr>';
    }
    else 
    {
        while ( $item = mysqli_fetch_array( $res ) )
        {
            echo '<tr align="center" class="tbl">';
            echo '<td>'.$item['marka'].'</td>';
            echo '<td>'.$item['type'].'</td>';
            echo '<td>'.$item['year'].'</td>';
            echo '<td>'.$item['cost_per_day'].'</td>';
            echo '<td>'.$item['deposit'].'</td>';
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
        echo '<h2>Добавить автомобиль</h2>';
        echo '<form name ="addform" action="'.$_SERVER['PHP_SELF'].'?action=add" method="POST">';
        echo '<button type ="button" onClick="history.back();">Отменить</button><br />';
        echo '<br><table border="1" class="data_tbl">';
        echo '<tr>';
        echo '<td>Марка</td>';
        echo '<td><input type="text" name="marka" value="" /></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Тип кузова</td>';
        echo '<td><input type="text" name="type" value="" /></td>';
        echo '</tr>';
        
        echo '<tr>';
        echo '<td>Год</td>';
        echo '<td><input type="text" name="year" value="" /></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Стоимость в сутки (в рублях)</td>';
        echo '<td><input type="text" name="cost_per_day" value="" /></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Залог (в рублях)</td>';
        echo '<td><input type="text" name="deposit" value="" /></td>';
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
            echo '<meta http-equiv="refresh" content="0;URL=auto_list.php">';
        }

        
        }


    function add_item()
        {
        global $link;
        $marka = mysqli_escape_string($link, $_POST['marka']);
        $type = mysqli_escape_string($link, $_POST['type']);
        $year = mysqli_escape_string($link, $_POST['year']);
        $cost_per_day = mysqli_escape_string($link, $_POST['cost_per_day']);
        $deposit = mysqli_escape_string($link, $_POST['deposit']);
        
        $query = "INSERT INTO auto (marka, type, year, cost_per_day, deposit) VALUES ('".$marka."','".$type."','".$year."','".$cost_per_day."','".$deposit."' );";
        mysqli_query($link, $query) or die ("Ошибка " . mysqli_error($link));
        echo '<meta http-equiv="refresh" content="0;URL=auto_list.php">';
        die();
        }


// Функция формирует форму для редактирования записи в таблице БД 
function get_edit_item_form() 
{
    if ($_SESSION['status'] == 1)
    {

 
global $link;
  echo '<div class="d_cont">';
  echo '<h2>Редактировать автомобиль</h2>'; 
  $query = 'SELECT * FROM auto WHERE id_auto='.$_GET['id_auto']; 
  $res = mysqli_query( $link, $query ) or die("Ошибка " . mysqli_error($link)); 
  $item = mysqli_fetch_array( $res ); 
  echo '<form name="editform" action="'.$_SERVER['PHP_SELF'].'?action=update&id_auto='.$_GET['id_auto'].'" method="POST">'; 
  echo '<button type="button" onClick="history.back();">Отменить</button><br />';
  echo '<br><table border="1" class="data_tbl">'; 
  echo '<tr>'; 
  echo '<td>Марка</td>'; 
  echo '<td><input type="text" name="marka" value="'.$item['marka'].'"></td>'; 
  echo '</tr>';
  echo '<tr>'; 
  echo '<td>Тип кузова</td>'; 
  echo '<td><input type="text" name="type" value="'.$item['type'].'"></td>'; 
  echo '</tr>';  
  echo '<tr>'; 
  echo '<td>Год</td>'; 
  echo '<td><input type="text" name="year" value="'.$item['year'].'"></td>'; 
  echo '</tr>';  
  echo '<tr>'; 
  echo '<td>Стоимость в сутки (в рублях)</td>'; 
  echo '<td><input type="text" name="cost_per_day" value="'.$item['cost_per_day'].'"></td>'; 
  echo '</tr>';  
  echo '<tr>'; 
  echo '<td>Залог (в рублях)</td>'; 
  echo '<td><input type="text" name="deposit" value="'.$item['deposit'].'"></td>'; 
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
        echo '<meta http-equiv="refresh" content="0;URL=auto_list.php">';
    }

}

function update_item()
{
    global $link;
    $marka = mysqli_escape_string( $link, $_POST['marka'] );
    $type = mysqli_escape_string( $link, $_POST['type'] );
    $year = mysqli_escape_string( $link, $_POST['year'] );
    $cost_per_day = mysqli_escape_string( $link, $_POST['cost_per_day'] );
    $deposit = mysqli_escape_string( $link, $_POST['deposit'] );
    
    $query = "UPDATE auto SET marka='".$marka."',type='".$type."',year='".$year."',
    cost_per_day='".$cost_per_day."',deposit='".$deposit."' WHERE id_auto=".$_GET['id_auto'];
    mysqli_query ( $link, $query ) or die("Ошибка" . mysqli_error($link));
   
    echo '<meta http-equiv="refresh" content="0;URL=auto_list.php">';
    die();

}

function delete_item(){
    if ($_SESSION['status'] == 1)
    {


    global $link;
    
    $query = "DELETE FROM auto WHERE id_auto=".$_GET['id_auto'];
   
    mysqli_query ($link, $query) or die("Ошибка " . mysqli_error($link));
    echo '<meta http-equiv="refresh" content="0;URL=auto_list.php">';
    die();
}
else
    {
        echo '<meta http-equiv="refresh" content="0;URL=auto_list.php">';
    }

    
    }

    
    ?>
    
    </body>
    </html>
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
        $query ='SELECT * FROM client';
        $res = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        echo '<div class="d_cont">';
        echo '<h2>Информация о клиентах</h2>';
        echo '<button type="button" onClick="history.back();">Назад</button><br>';
        echo '<br><table border="1" class="data_tbl">';
        echo '<tr align="center"><th>ФИО</th><th>Телефон</th><th>Адрес</th><th>Данные паспорта</th></tr>';
        if (empty($_SESSION['id']))
        {
        while ( $item = mysqli_fetch_array( $res ) )
        {
            echo '<tr align="center" class="tbl">';
            echo '<td>'.$item['fio_client'].'</td>';
            echo '<td>'.$item['phone'].'</td>';
            echo '<td>'.$item['address'].'</td>';
            echo '<td>'.$item['pass_data'].'</td>';
            
        }
    }
    elseif ($_SESSION['status'] == 1)
    {
        while ( $item = mysqli_fetch_array( $res ) )
        {
            echo '<tr align="center" class="tbl">';
            echo '<td>'.$item['fio_client'].'</td>';
            echo '<td>'.$item['phone'].'</td>';
            echo '<td>'.$item['address'].'</td>';
            echo '<td>'.$item['pass_data'].'</td>';
            
            echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=editform&id_client='.$item['id_client'].'"><img src="img/edit.png" title="Редактировать"></a></td>';
            echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=delete&id_client='.$item['id_client'].'"><img src="img/drop.png" title="Удалить" onClick="return confirmDelete();"></a></td>';
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
            echo '<td>'.$item['phone'].'</td>';
            echo '<td>'.$item['address'].'</td>';
            echo '<td>'.$item['pass_data'].'</td>';
            
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
        echo '<h2>Добавить клиента</h2>';
        echo '<form name ="addform" action="'.$_SERVER['PHP_SELF'].'?action=add" method="POST">';
        echo '<button type ="button" onClick="history.back();">Отменить</button><br />';
        echo '<br><table border="1" class="data_tbl">';
        echo '<tr>';
        echo '<td>ФИО</td>';
        echo '<td><input type="text" name="fio_client" value="" /></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Телефон</td>';
        echo '<td><input type="text" name="phone" value="" /></td>';
        echo '</tr>';
        
        echo '<tr>';
        echo '<td>Адрес</td>';
        echo '<td><input type="text" name="address" value="" /></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Данные паспорта</td>';
        echo '<td><input type="text" name="pass_data" value="" /></td>';
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
            echo '<meta http-equiv="refresh" content="0;URL=clients_list.php">';
        }

        
        }


    function add_item()
        {
        global $link;
        $fio_client = mysqli_escape_string($link, $_POST['fio_client']);
        $phone = mysqli_escape_string($link, $_POST['phone']);
        $address = mysqli_escape_string($link, $_POST['address']);
        $pass_data = mysqli_escape_string($link, $_POST['pass_data']);
        
        $query = "INSERT INTO client (fio_client, phone, address, pass_data) VALUES ('".$fio_client."','".$phone."','".$address."','".$pass_data."' );";
        mysqli_query($link, $query) or die ("Ошибка " . mysqli_error($link));
        echo '<meta http-equiv="refresh" content="0;URL=clients_list.php">';
        die();
        }


// Функция формирует форму для редактирования записи в таблице БД 
function get_edit_item_form() 
{
    if ($_SESSION['status'] == 1)
    {

 
global $link;
  echo '<div class="d_cont">';
  echo '<h2>Редактировать данные клиента</h2>'; 
  $query = 'SELECT * FROM client WHERE id_client='.$_GET['id_client']; 
  $res = mysqli_query( $link, $query ) or die("Ошибка " . mysqli_error($link)); 
  $item = mysqli_fetch_array( $res ); 
  echo '<form name="editform" action="'.$_SERVER['PHP_SELF'].'?action=update&id_client='.$_GET['id_client'].'" method="POST">'; 
  echo '<button type="button" onClick="history.back();">Отменить</button><br />';
  echo '<br><table border="1" class="data_tbl">'; 
  echo '<tr>'; 
  echo '<td>ФИО</td>'; 
  echo '<td><input type="text" name="fio_client" value="'.$item['fio_client'].'"></td>'; 
  echo '</tr>';
  echo '<tr>'; 
  echo '<td>Телефон</td>'; 
  echo '<td><input type="text" name="phone" value="'.$item['phone'].'"></td>'; 
  echo '</tr>';  
  echo '<tr>'; 
  echo '<td>Адрес</td>'; 
  echo '<td><input type="text" name="address" value="'.$item['address'].'"></td>'; 
  echo '</tr>';  
  echo '<tr>'; 
  echo '<td>Данные паспорта</td>'; 
  echo '<td><input type="text" name="pass_data" value="'.$item['pass_data'].'"></td>'; 
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
        echo '<meta http-equiv="refresh" content="0;URL=clients_list.php">';
    }

}

function update_item()
{
    global $link;
    $fio_client = mysqli_escape_string( $link, $_POST['fio_client'] );
    $phone = mysqli_escape_string( $link, $_POST['phone'] );
    $address = mysqli_escape_string( $link, $_POST['address'] );
    $pass_data = mysqli_escape_string( $link, $_POST['pass_data'] );
    
    
    $query = "UPDATE client SET fio_client='".$fio_client."',phone='".$phone."',address='".$address."',
    pass_data='".$pass_data."' WHERE id_client=".$_GET['id_client'];
    mysqli_query ( $link, $query ) or die("Ошибка" . mysqli_error($link));
   
    echo '<meta http-equiv="refresh" content="0;URL=clients_list.php">';
    die();

}

function delete_item(){
    if ($_SESSION['status'] == 1)
    {


    global $link;
    
    $query = "DELETE FROM client WHERE id_client=".$_GET['id_client'];
   
    mysqli_query ($link, $query) or die("Ошибка " . mysqli_error($link));
    echo '<meta http-equiv="refresh" content="0;URL=clients_list.php">';
    die();
}
else
    {
        echo '<meta http-equiv="refresh" content="0;URL=clients_list.php">';
    }

    
    }

    
    ?>
    
    </body>
    </html>
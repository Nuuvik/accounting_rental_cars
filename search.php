<?php
session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<script type="text/javascript" src="js/script.js"></script>
<meta charset="utf-8">
<title>Прокат автомобилей "Варан СПб"</title>
</head>
<body>
  <?php
require_once "menu.php";
?>
<div class="d_cont">
<h2>Поиск информации о прокатах</h2>

<table border="0" class="data_tbl">
  <tr>
    <td>
      <b>ФИО Клиента</b><input list="fio_list" name="fio_list">
    </td>
    <td>
<b>Автомобиль</b><input list="auto_list" name="auto_list">
    </td>
    <td>
<b>Дата начала аренды</b><input list="date_rent_list" name="date_rent_list">
    </td>
  </tr>
  <tr>
    <td colspan="3" align="center">
      <input type="button" onclick="ajaxFunction()" value="Поиск">
      <input type="button" onclick="res()" value="Сброс">
    </td>
  </tr>
</table>
<div id="ajaxDiv"></div>
<?php
require_once 'login.php';

$sql1="SELECT DISTINCT fio_client FROM v_prokate";
$res1=mysqli_query($link,$sql1) or die("Error in $sql1 : ".mysql_error());
echo '<datalist id="fio_list">';
while ($row=mysqli_fetch_array($res1))
{
  $fio_client=htmlspecialchars($row['fio_client']);
  echo "<option value='$fio_client'></option>";
}
echo "</datalist>";

$sql2="SELECT DISTINCT marka FROM v_prokate";
$res2=mysqli_query($link,$sql2) or die("Error in $sql2 : ".mysql_error());
echo '<datalist id="auto_list">';
while ($row=mysqli_fetch_array($res2))
{
  $marka=htmlspecialchars($row['marka']);
  echo "<option value='$marka'></option>";
}
echo "</datalist>";

$sql3="SELECT DISTINCT date_rent FROM v_prokate";
$res3=mysqli_query($link,$sql3) or die("Error in $sql3 : ".mysql_error());
echo '<datalist id="date_rent_list">';
while ($row=mysqli_fetch_array($res3))
{
  $date_rent=htmlspecialchars($row['date_rent']);
  echo "<option value='$date_rent'></option>";
}
echo "</datalist>";


 ?>
</div>
</body>
</html>

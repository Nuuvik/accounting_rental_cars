

<?php
require_once 'login.php';
$search1 = $_GET['search1'];
$search2 = $_GET['search2'];
$search3 = $_GET['search3'];

$search1 = mysqli_real_escape_string($link, $search1);
$search2 = mysqli_real_escape_string($link, $search2);
$search3 = mysqli_real_escape_string($link, $search3);

//build query
if (empty($search1) && empty($search2))
{
    $query = "SELECT * FROM v_prokate WHERE date_rent LIKE '%$search3%'";
}
elseif (empty($search1) && empty($search3))
{
    $query = "SELECT * FROM v_prokate WHERE marka LIKE '%$search2%'";
}
elseif (empty($search2) && empty($search3))
{
    $query = "SELECT * FROM v_prokate WHERE fio_client LIKE '%$search1%'";
}
elseif (empty($search1))
{
    $query = "SELECT * FROM v_prokate WHERE marka LIKE '%$search2%' AND date_rent LIKE '%$search3%'";
}
elseif (empty($search2))
{
    $query = "SELECT * FROM v_prokate WHERE fio_client LIKE '%$search1%' AND date_rent LIKE '%$search3%'";
}
elseif (empty($search3))
{
    $query = "SELECT * FROM v_prokate WHERE fio_client LIKE '%$search1%' AND marka LIKE '%$search2%'";
}
else
{
    $query = "SELECT * FROM v_prokate WHERE fio_client LIKE '%$search1%' AND marka LIKE '%$search2%' AND date_rent LIKE '%$search3%'";
}

$qry_result = mysqli_query($link, $query) or die(mysql_error());

//build result string

echo "<br /><table border=1 class='data_tbl'>";
echo "<tr>";
echo "<th>ФИО клиента</th>";
echo "<th>Автомобиль</th>";
echo "<th>Дата начала аренды</th>";
echo "<th>Дата окончания аренды</th>";
echo "</tr>";

while ( $row = mysqli_fetch_array( $qry_result ) )
        {
            echo "<tr align='center'>";
            echo "<td>$row[fio_client]</td>";
            echo "<td>$row[marka]</td>";
            echo "<td>$row[date_rent]</td>";
            echo "<td>$row[date_end]</td>";
            echo "</tr>";
        }
    echo "</table><br />";
                                
    ?>
        
</body>
</html>

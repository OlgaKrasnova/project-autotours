<?php
require_once '../connection.php'; // подключаем скрипт              
// подключаемся к серверу
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link)); 
    ?>
    <h3>Популярность заказов среди пользователей:</h3>
<?php 
$sql_dir = mysqli_query($link, "SELECT * FROM direction");
print '<table class="big-table">
                  <thead>
                    <tr><td>Направление</td><td>Количество</td></tr>
                  </thead>';

while($row_dir = mysqli_fetch_array($sql_dir)) { 
    $sql_c_tour = mysqli_query($link, "SELECT COUNT(*) FROM tours WHERE id_direction = ".$row_dir['id_direction']."");
    while($row_c_tour = mysqli_fetch_array($sql_c_tour)) { 
        print '<tr>
                    <td>'.$row_dir['name_direction'].'</td>
                    <td>'.$row_c_tour['COUNT(*)'].'</td>
            </tr>';
    }
}
print '</table>';
?>
<h3>Популярность заказов среди пользователей:</h3>
<?php 
print '<table class="big-table">
        <thead>
            <tr><td>Направление</td><td>Количество</td></tr>
        </thead>';
$sql_tour = mysqli_query($link, "SELECT * FROM tours");
while($row_tour = mysqli_fetch_array($sql_tour)) { 
    $sql_fav = mysqli_query($link, "SELECT COUNT(*) FROM favorites WHERE id_tour = ".$row_tour['id_tour']."");
    while($row_fav = mysqli_fetch_array($sql_fav)) { 
        print '<tr>
                    <td>'.$row_tour['title'].'</td>
                    <td>'.$row_fav['COUNT(*)'].'</td>
            </tr>';
    }
}
print '</table>';
?>
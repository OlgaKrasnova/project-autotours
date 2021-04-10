<?php
require_once '../connection.php'; // подключаем скрипт
    
// подключаемся к серверу
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));

if($_GET["p"] == "perf") 
{
$query ="SELECT * FROM performers ORDER BY name_performer DESC";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
         
        if($result)
        { 
          print '
          <h3>Исполнители туров:</h3>
          <table class="big-table">
          <thead>
            <tr><td>Наименование исполнителя</td><td>ИНН</td><td>Адрес регистрации</td><td>Телефон</td><td>E-mail</td></tr>
          </thead>';
          
            while($row = mysqli_fetch_array($result)) { 
              
               print '<tr>
                            <td>'.$row["name_performer"].'</td>
                            <td>'.$row["INN"].'</td>
                            <td>'.$row["address"].'</td>
                            <td>'.$row["phone"].'</td>
                            <td>'.$row["email"].'</td>
                    </tr>';
              }
            
            print '</table>';
          }
        }
?>
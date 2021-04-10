<?php
require_once '../connection.php'; // подключаем скрипт
    
// подключаемся к серверу
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));

if($_GET["p"] == "auto") 
{
$query ="SELECT * FROM cars ORDER BY mark DESC";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
         
        if($result)
        { 
          print '
          <h3>Автомобили:</h3>
          <table class="big-table">
          <thead>
            <tr><td>Изображение</td><td>Марка</td><td>Модель</td><td>Тип</td><td>Объем двигателя</td><td>Мощность, л.с.</td><td></td></tr>
          </thead>';
          
            while($row = mysqli_fetch_array($result)) { 
              
               print '<tr>
                            <td><img src=../'.$row["image"].'></td>
                            <td>'.$row["mark"].'</td>
                            <td>'.$row["model"].'</td>
                            <td>'.$row["type"].'</td>
                            <td>'.$row["volume"].'</td>
                            <td>'.$row["power"].'</td>
                            <td><button><a href=""><img src="../img/edit.png"></button></a>
                            <i>&emsp;</i>
                            <button><a href=""><img src="../img/delete.png"></button></a></td>
                    </tr>';
              }
            
            print '</table>';
          }
        }
?>
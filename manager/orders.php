<?php
require_once '../connection.php'; // подключаем скрипт
    
    // подключаемся к серверу
    $link = mysqli_connect($host, $user, $password, $database) 
        or die("Ошибка " . mysqli_error($link));

  if($_GET["p"] == "order") 
  {
  $query ="SELECT * FROM orders";
  if ($_GET['status']) {
    $query ="SELECT * FROM orders WHERE status = ".$_GET['status']." ";
  } else {$query ="SELECT * FROM orders";};
   $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
             
            if($result)
            { 
              print '
              <h3>Бронирования туров:</h3>
              <div class="filter">
              <span><b>Фильтр по статусу:</b></span> 
              <form>
                <input name="p" value="order" hidden><input name="status" value="1" hidden>
                <button>Оформляются</button>
              </form>
              <form>
                <input name="p" value="order" hidden><input name="status" value="2" hidden>
                <button>Забронированные</button>
              </form>
              <form>
                <input name="p" value="order" hidden><input name="status" value="3" hidden>
                <button>Отмененные</button>
              </form>
              <form>
                <input name="p" value="order" hidden><input name="status" value="" hidden>
                <button>Все</button>
              </form>
              </div>
              <hr>
              <table class="big-table">
              <thead>
                <tr><td>Наименование тура</td><td>Клиент</td><td>Дата начала тура</td><td>Дата окончания тура</td><td>Статус</td></tr>
              </thead>';
              
                while($row = mysqli_fetch_array($result)) { 
                  $query_tour ="SELECT * FROM tours WHERE id_tour = ".$row["id_tour"]."";
                  $result_tour = mysqli_query($link, $query_tour) or die("Ошибка " . mysqli_error($link));
                  
                  $query_user ="SELECT * FROM users WHERE id_user = ".$row["id_user"]."";
                  $result_user = mysqli_query($link, $query_user) or die("Ошибка " . mysqli_error($link));
                  
                  while($row_tour = mysqli_fetch_array($result_tour)) {
                    if ($row["status"] == "3") {
                      $status = "Отменен";
                      $backcolor = "#f9bebe";
                      $color = "red";
                    } else if ($row["status"] == "2") {
                      $status = "Забронирован";
                      $backcolor = "#b7fbb7";
                      $color = "green";
                    } else if ($row["status"] == "1"){
                      $status = "Оформляется";
                      $backcolor = "transparent";
                      $color = "orange";
                    }
                   print '<tr style="background: '.$backcolor.';">
                                <td>'.$row_tour["title"].'</td>';
                                while ($row_user = mysqli_fetch_array($result_user)) 
                                print '<td>'.$row_user["FIO"].'</td>';
                                print '<td>'.$row["departure"].'</td>
                                <td>'.$row["arrival"].'</td>
                                <td><span style="color:'.$color.';">'.$status.'</td>
                        </tr>';
                  }
                }
                print '</table>';
              }
            }
            ?>
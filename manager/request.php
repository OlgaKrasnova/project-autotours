<?php
require_once '../connection.php'; // подключаем скрипт
    
        // подключаемся к серверу
        $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));

      if($_GET["p"] == "request" && !isset($_GET["req-edit"])) 
      {
      $query ="SELECT * FROM requests ORDER BY id_request DESC";
       $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
                 
                if($result)
                { 
                  print '
                  <h3>Новые заявки на обратный звонок:</h3>
                  <table class="big-table">
                  <thead>
                    <tr><td>Имя и фамилия</td><td>Телефон</td><td>Цель звонка</td><td>Статус</td></tr>
                  </thead>';
                  
                    while($row = mysqli_fetch_array($result)) { 
                      
                        if ($row["status"] == "3") {
                          $status = "Не дозвонились";
                          $backcolor = "#f9bebe";
                          $color = "red";
                        } else if ($row["status"] == "2") {
                          $status = "Обработан";
                          $backcolor = "#b7fbb7";
                          $color = "green";
                        } else if ($row["status"] == "1"){
                          $status = "Ожидает звонка";
                          $backcolor = "transparent";
                          $color = "orange";
                        }
                       print '<tr style="background: '.$backcolor.';">
                                    <td>'.$row["FIO"].'</td>
                                    <td>'.$row["phone"].'</td>
                                    <td>'.$row["purpose"].'</td>
                                    <td style="color:'.$color.'">'.$status.'</td>
                                    <td><button><a href="manager.php?p=request&req-edit='.$row["id_request"].'"><img src="../img/edit.png"></button></a>
                                    <i>&emsp;</i>
                                    <button><a href="manager.php?p=request&req-delete='.$row["id_request"].'"><img src="../img/delete.png"></button></a></td>
                            </tr>';
                      }
                    
                    print '</table>';
                  }
                }
                if(isset($_GET["req-edit"])) 
                  {
                  $query ="SELECT * FROM requests WHERE id_request = ".$_GET["req-edit"]."";
                  $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
                            
                            if($result)
                            { 
                              print '
                              <h3>Редактирование заявки:</h3>';
                              
                                while($row = mysqli_fetch_array($result)) { 
                                  
                                  print '
                                  <form class="big-form" action="" method="POST" id="popup" name="popup">
                                    <label>Фамилия и имя</label><i> *</i><br><input type="text" name="FIO" required value="'.$row["FIO"].'"><br>
                                    <label>Номер телефона</label><i> *</i><br><input type="tel" name="phone" required value="'.$row["phone"].'" minlength="12"><br>
                                    <label>Цель звонка</label><br><textarea name="purpose" value="'.$row["purpose"].'"></textarea><br>
                                    <label>Статус</label><i> *</i><br><select name="status">';
                                    if ($row["status"] == "1") {
                                      print '<option value="'.$row["status"].'">Ожидает звонка</option>
                                      <option value="2">Обработан</option>
                                      <option value="3">Не дозвонились</option>';
                                    }
                                    if ($row["status"] == "2") {
                                      print '<option value="'.$row["status"].'">Обработан</option>
                                      <option value="1">Ожидает звонка</option>
                                      <option value="3">Не дозвонились</option>';
                                    }
                                    if ($row["status"] == "3") {
                                      print '<option value="'.$row["status"].'">Не дозвонились</option>
                                      <option value="1">Ожидает звонка</option>
                                      <option value="2">Обработан</option>';
                                    }
                                    print '</select><br>
                                    <i>* Поля, отмеченные звездочкой, обязательны для заполнения</i><br><br>
                                    <button type="submit" name="submit" value="Сохранить">Сохранить</button>
                                  </form>';
                                  }

                                  if( isset($_POST['submit']) && $_POST['submit']== 'Сохранить')
                                    {               
                                    $sql_res_=mysqli_query($link, 'UPDATE requests SET 
                                          FIO = "'.htmlspecialchars($_POST['FIO']).'",
                                          phone = "'.htmlspecialchars($_POST['phone']).'",
                                          purpose = "'.htmlspecialchars($_POST['purpose']).'",
                                          status = "'.htmlspecialchars($_POST['status']).'" WHERE id_request ='.$_GET["req-edit"].'');
                                    
                                    // если при выполнении запроса произошла ошибка – выводим сообщение
                                    if( mysqli_errno($link) )
                                    echo '<script>alert("Данные завки не изменены!");'.mysqli_error($link);
                                    else // если все прошло нормально – выводим сообщение
                                    echo '<script>alert("Данные завки успешно изменены!"); window.location = "manager.php?p=request";</script>';
                                    
                                    }
                              }
                            }

                            if(isset($_GET["req-delete"])) 
                            {
                                    $sql_res_=mysqli_query($link, 'DELETE FROM requests WHERE id_request ='.$_GET["req-delete"].'');
                                    
                                    // если при выполнении запроса произошла ошибка – выводим сообщение
                                    if( mysqli_errno($link) )
                                    echo '<script>alert("Заявка не удалена!");</script>'.mysqli_error($link);
                                    else // если все прошло нормально – выводим сообщение
                                    echo '<script>alert("Заявка успешно удалена!"); window.location = "manager.php?p=request";</script>';
                                  
                            }
                ?>
                <script src="../js/edittables.js"></script>
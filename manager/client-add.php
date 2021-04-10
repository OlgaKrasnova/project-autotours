<?php
require_once '../connection.php'; // подключаем скрипт
    
$search_q=$_GET['search_q'];
        
if ($search_q) {
    $search_q = trim($search_q);
    $search_q = strip_tags($search_q);

    $query = "SELECT * FROM `users` WHERE FIO LIKE '%".$search_q."%' AND role = 'P' ORDER BY FIO ASC";  
} else { 
    $query ="SELECT * FROM users WHERE role = 'P' ORDER BY FIO ASC";
} 

        // подключаемся к серверу
        $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));

      if($_GET["p"] == "add") 
      {
       $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
                 
                if($result)
                { 
                  print '
                  <h3>Клиентcкая база:</h3>
                  <form method="get" action="manager.php" style="width: 100%;">
                    <div class="input-group mb-3">
                            <input type="text" class="search-inpt" name="search_q" placeholder="Поиск по имени или фамилии">
                                <button class="search-btn" type="submit">Поиск</button>
                            <input name="p" value="add" hidden>
                        </div>
                    </form>
                  <table class="big-table">
                  <thead>
                    <tr><td>Имя и фамилия</td><td>E-mail</td><td>Телефон</td><td></td></tr>
                  </thead>';
                  
                    while($row = mysqli_fetch_array($result)) { 
                      
                       print '<tr>
                                    <td>'.$row["FIO"].'</td>
                                    <td>'.$row["login"].'</td>
                                    <td>'.$row["phone"].'</td>
                                    <td><button><a href=""><img src="../img/edit.png"></button></a>
                                    <i>&emsp;</i>
                                    <button><a href=""><img src="../img/delete.png"></button></a></td>
                            </tr>';
                      }
                    
                    print '</table>';
                  }
                }
                ?>
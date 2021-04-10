<?php
    session_start(); 
?> 
<!doctype html>
<html lang="ru">
  <head>
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/steps.css">
    <script src="js/jquery-1.7.2.min.js"></script>
   
    <title>ВКР</title>
  </head>
  <body>
  <?php
        include 'header.php';
        ?>

            <h1>Оформить тур:</h1>
            <?php
            require_once 'connection.php'; // подключаем скрипт
                
            // подключаемся к серверу
            $link = mysqli_connect($host, $user, $password, $database) 
                or die("Ошибка " . mysqli_error($link));
        if (isset($_GET['id_tour'])) {
            $query = "SELECT * FROM `tours` WHERE id_tour = ".$_GET["id_tour"]."";
            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
                if($result)
                { 
                    print '<div class="filter">';
                    while($row = mysqli_fetch_array($result)) { 
                        $article = preg_match("/^((\S+\s){8})/s", $row["description"], $m) ? $m[1]: $row["description"];

                        if ($row["popular"] == "1") {
                            $span = '<span>Популярное!</span>';
                          } else {$span = '';}
                          print '<figure>';

                         if(isset($_SESSION['id_cl'])){
                          $query_favorites = "SELECT * FROM `favorites` WHERE id_user = ".$_SESSION['id_cl']."";
                          $result_favorites = mysqli_query($link, $query_favorites) or die("Ошибка " . mysqli_error($link)); 
                         }
                          if($result_favorites)
                          { 
                              while($row_fav = mysqli_fetch_array($result_favorites)) { 

                       
                        if ($row_fav['id_tour'] == $row['id_tour']) {
                          print '<em class="favorite-del" onclick="favoriteDel('.$row["id_tour"].');" id="em'.$row["id_tour"].'"></em>';
                        }
                        if ($row_fav['id_tour'] != $row['id_tour']) {
                          print '<em class="favorite-add" onclick="favoriteAdd('.$row["id_tour"].');" id="em'.$row["id_tour"].'"></em>';
                        }

                      }
                    }
                       
                      print '<a class="link-black" href="tour.php?tour='.$row["id_tour"].'">
                          <img class="photo-land" src="'.$row["image"].'">'.$span.'
                          <figcaption>
                            <h4>'.$row["title"].'</h4>
                            <p>'.$article.'...</p>
                            <div class="info">Протяженность: '.$row["length"].' км</div>
                            <div class="info">Количество дней: '.$row["duration"].'</div>
                            </figcaption>
                            </a>
                        </figure>';
                      }
                      print '</div>';
                };
            ?>

    <form action="registration.php" method="POST" enctype="multipart/form-data" class="big-form">
                      <p><?php
                      $res_user = mysqli_query($link, "SELECT * FROM `users` WHERE id_user = ".$_SESSION['id_cl']."") or die("Ошибка " . mysqli_error($link));
                      while($row_user = mysqli_fetch_array($res_user)) { 
                          print 'ФИО: <b>'.$row_user["FIO"].'</b><i>&emsp;</i> Телефон: <b>'.$row_user["phone"].'</b><i>&emsp;</i> E-mail: <b>'.$row_user["login"].'</b>';
                      }
                           ?></p>
                    <input name="id_tour" type="text" value="<? echo $_GET['id_tour'];?>" hidden><input name="id_user" type="text" value="<? echo $_SESSION['id_cl'];?>" hidden><br>
                      <label for="departure">Дата начала тура:</label><i> *</i><br>
                        <input type="date" name="departure" required><br>
                    <label for="arrival">Дата окончания тура:</label><i> *</i><br>
                        <input type="date" name="arrival" required><br>
                      
                      <label for="agree">Я даю свое согласие на обработку персональных данных:</label><i> *</i>
                        <input name="agree" type="checkbox" id="agree" required><br>
                      <i>* Поля, отмеченные звездочкой, обязательны для заполнения</i><br><br>
                      <button name="button" value="Сохранить">Отправить заявку</button>
                      <br><br><br><br>
                  </form>
<?php 
                 // если были переданы данные для добавления в БД
                 if( isset($_POST['button']) && $_POST['button']== 'Сохранить')
                 {               
                 $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

                 $sql_res_prod=mysqli_query($link, 'INSERT INTO users (`FIO`, `login`, `pass`, `role`) VALUES (
                      "'.htmlspecialchars($_POST['FIO']).'",
                      "'.htmlspecialchars($_POST['login']).'",
                      "'.$pass_hash.'",
                      "P")');
                 
                 // если при выполнении запроса произошла ошибка – выводим сообщение
                 if( mysqli_errno($link) )
                 echo '<hr><div class="error col" style="color:red; font-size:20px">Запись не добавлена</div>'.mysqli_error($link);
                 else // если все прошло нормально – выводим сообщение
                 echo '<hr><div class="ok col" style="color:green; font-size:20px">Запись добавлена</div>';
                 
                 }
        }
?>

        <div class="image-tape">
            <img src="img/13.jpg">
            <img src="img/14.jpg">
            <img src="img/15.jpg">
            <img src="img/16.jpg">
            <img src="img/17.jpg">
        </div>
    
    
 
    <?php
        include 'footer.php';
        ?>
     </body>
     <script type="text/javascript" src="js/slide.js"></script>
</html>
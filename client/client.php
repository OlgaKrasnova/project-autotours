<?php
    session_start(); 
?> 
<!doctype html>
<html lang="ru">
  <head>
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/steps.css">
    <script src="../js/jquery-1.7.2.min.js"></script>
    
    <title>ВКР</title>
  </head>
  <body>
<?php 
           if (!isset($_SESSION['id_cl'])) {

            echo '
            <img class="back-client" src="../img/back-client.jpg">
            <section class="auth-client">
            <div class="form-client">
              <h3>Вход в личный кабинет:</h3>
              <br><br>
              <form action="client.php" method="POST">
                      <label for="login">Введите логин</label><br>
                    <input name="login" type="text" required><br>
                      <label for="pass">Введите пароль</label><br>
                    <input name="pass" type="password" id="pass" required> <br>
                  <button>Войти</button><br><br>
                    <a href="../index.php" style="color: black;">На главную</a>
              </form>
            </div>
            </section>';

            require_once '../connection.php'; // подключаем скрипт
                
                // подключаемся к серверу
                $link = mysqli_connect($host, $user, $password, $database) 
                    or die("Ошибка " . mysqli_error($link));
                   
                $sql_res = mysqli_query($link, 'SELECT id_user, FIO, login, pass, role FROM users');
                for ($i=0; $i < mysqli_num_rows($sql_res); $i++) {
                    $row = mysqli_fetch_array($sql_res, MYSQLI_ASSOC);
                    // print_r($row);
                    $adm_id = $row['id_user'];
                    $adm_FIO = $row['FIO'];
                    $adm_log = $row['login'];
                    $adm_pass = $row['pass'];
                    $adm_role = $row['role'];
                    // echo '<br>'.$adm_log.' '.$adm_pass;
                    if(password_verify($_POST['pass'], $adm_pass) == TRUE && $_POST['login'] == $adm_log && $adm_role == "P") {
                        $_SESSION['id_cl'] = $adm_id;
                        $_SESSION['id_FIO'] = $adm_FIO;
                        echo "<script>window.location = 'client.php?p=favor'</script>";
                    } 
                    $pass_hash = md5($_POST['pass']);
                    if($adm_pass == $pass_hash && $_POST['login'] == $adm_log && $adm_role == "M") {
                      $_SESSION['id'] = $adm_id;
                      echo "<script>window.location = '../manager/manager.php?p=request'</script>";
                  }
                }
    
                

            }  else {
                  echo '
                  <nav>
                  <ul id="navbar">
                          <li id="title"><img src="../img/car.png" id="logo"></li>
                          <li><a href="../index.php">Главная</a></li>
                          <li><a href="#">Новости</a></li>
                          <li><a href="#">Каталог</a>
                            <ul>
                              <li><a href="../catalog.php?direction=2">Прибалтика</a></li>
                              <li><a href="../catalog.php?direction=3">Европа</a></li>
                              <li><a href="../catalog.php?direction=4">Скандинавия</a></li>
                              <li><a href="../catalog.php?direction=1">Россия</a></li>
                            </ul>
                          </li>
                          <li><a href="#">О нас</a></li>
                        </ul>
                        <div class="auth">
                            <h4 style="color: white;">'.$_SESSION['id_FIO'].'</h4>
                        </div>
                        <form method="POST">
                            <button name="exit" class="order-trip">Выйти</button>
                        </form>
                      </nav>';

              if (isset($_POST["exit"])) {
                session_destroy();
                echo "<script>window.location = 'client.php'</script>";
              }

              print '<ol>
              <li><a href="?p=favor">Избранное</a></li>
              <li><a href="?p=order">Оформленные туры</a></li>
              </ol>';
            }

        require_once '../connection.php'; // подключаем скрипт
    
        // подключаемся к серверу
        $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));

      if($_GET["p"] == "order") 
      {
      $query ="SELECT * FROM orders WHERE id_user = ".$_SESSION['id_cl']."";
       $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
                 
                if($result)
                { 
                  print '
                  <h3>Мои оформленные туры:</h3>
                  <table class="big-table">
                  <thead>
                    <tr><td>Наименование тура</td><td>Дата начала тура</td><td>Дата окончания тура</td><td>Статус</td></tr>
                  </thead>';
                  
                    while($row = mysqli_fetch_array($result)) { 
                      $query_tour ="SELECT * FROM tours WHERE id_tour = ".$row["id_tour"]."";
                      $result_tour = mysqli_query($link, $query_tour) or die("Ошибка " . mysqli_error($link));
                      
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
                                    <td>'.$row_tour["title"].'</td>
                                    <td>'.$row["departure"].'</td>
                                    <td>'.$row["arrival"].'</td>
                                    <td><span style="color:'.$color.';">'.$status.'</td>
                            </tr>';
                      }
                    }
                    print '</table>';
                  }
                }

                if($_GET["p"] == "favor") 
                {
                print '<section class="all-tours">';
                $query_favorites = "SELECT * FROM `favorites` WHERE id_user = ".$_SESSION['id_cl']."";
                $result_favorites = mysqli_query($link, $query_favorites) or die("Ошибка " . mysqli_error($link)); 
                if($result_favorites)
                { 
                    while($row = mysqli_fetch_array($result_favorites)) { 

                      $query_tour = "SELECT * FROM `tours` WHERE id_tour = ".$row['id_tour']."";
                      $result_tour = mysqli_query($link, $query_tour) or die("Ошибка " . mysqli_error($link)); 
                      
                        
                      while($row_tour = mysqli_fetch_array($result_tour)) { 
                        if ($row_tour["popular"] == "1") {
                            $span = '<span>Популярное!</span>';
                          } else {$span = '';}
                          $article = preg_match("/^((\S+\s){8})/s", $row_tour["description"], $m) ? $m[1]: $row_tour["description"];
                       print '<figure>
                       <em class="favorite-del" onclick="favoriteDel('.$row["id_tour"].');" id="em'.$row["id_tour"].'"></em>
                       <a class="link-black" href="../tour.php?tour='.$row["id_tour"].'">
                          <img class="photo-land" src="../'.$row_tour["image"].'">'.$span.'
                          <figcaption>
                            <h4>'.$row_tour["title"].'</h4>
                            <p>'.$article.'...</p>
                            <div class="info">Протяженность: '.$row_tour["length"].' км</div>
                            <div class="info">Количество дней: '.$row_tour["duration"].'</div>
                            </figcaption>
                            </a>
                        </figure>';
                      }
                    }
                  }
                  print '</section>';
                };

?> 
<script type="text/javascript">

  var user = <?php echo $_SESSION['id_cl']; ?>;
     function favoriteDel(tour) {
        $.ajax({
            type: "POST",
            url: 'favorite_del.php',
            data: {id_tour : tour, id_user: user},
            success: function(response)
            {
                var jsonData = JSON.parse(response);
                if (jsonData.success == "1")
                {
                  alert('Тур удален из избранного!');
                }
                else
                {
                    alert('Invalid Credentials!');
                }
           }
       });
     };
</script>
     <script src="../js/form.js"></script>
</html>
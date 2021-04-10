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

            <h1>Подбор тура:</h1>

    <form action="calculate.php" method="POST" class="big-form">
    <label for="length">Количество дней:</label><br>
        <input name="length" type="number"><br>   
    
      <label for="FIO">Протяженность:</label>
      <output name="ageOutputName" id="ageOutputId">240</output> км.<br>
        <input type="range" name="ageInputName" class="slider" id="ageInputId" value="240" min="1" max="1000" oninput="ageOutputId.value = ageInputId.value"><br>
              
      <label for="login">Направление</label><br>
      <select name="direction">
        <option>Любое</option>
        <option value="2">Прибалтика</option>
        <option value="3">Европа</option>
        <option value="4">Скандинавия</option>
        <option value="1">Россия</option>
      </select><br>
        <i></i><br><br>
        <button name="button" class="button-order" value="Сохранить">Подобрать</button>
        <br><br><br><br>
      </form>
<?php 
                  require_once 'connection.php'; // подключаем скрипт
                
                  // подключаемся к серверу
                  $link = mysqli_connect($host, $user, $password, $database) 
                      or die("Ошибка " . mysqli_error($link));
                 
                 // если были переданы данные для добавления в БД
                 if( isset($_POST['button']) && $_POST['button']== 'Сохранить')
                 {  
                  $query ="SELECT * FROM tours WHERE id_direction = ".$_POST["direction"]."";
                  if (!$_POST["direction"]) 
                      $query ="SELECT * FROM tours";


                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
                if($result)
                { 
                    while($row = mysqli_fetch_array($result)) { 
                        $article = preg_match("/^((\S+\s){8})/s", $row["description"], $m) ? $m[1]: $row["description"];

                        if ($row["popular"] == "1") {
                            $span = '<span>Популярное!</span>';
                          } else {$span = '';}
                          print '<figure>';

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
</html>



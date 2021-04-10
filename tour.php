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
    <script src="https://api-maps.yandex.ru/2.0/?load=package.standard,package.route&amp;lang=ru-RU&amp;apikey=c90517d4-3f45-4274-b831-0a151368b274" type="text/javascript"></script>
    <script src="https://yandex.st/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
    <title>ВКР</title>
  </head>
  <body>
  <?php
    include 'header.php';
  ?>

    <?php
        require_once 'connection.php'; // подключаем скрипт
    
        // подключаемся к серверу
        $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));

        $search_q=$_POST['search_q'];
        
        
        $query ="SELECT * FROM tours WHERE id_tour = ".$_GET["tour"]."";
        
          
      
        
      
    
    ?>
    
<section>
     
    <?php
                // выполняем операции с базой данных
                
                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
                 
                if($result)
                { 
                    while($row = mysqli_fetch_array($result)) { 

                      $query_perf ="SELECT * FROM performers WHERE id_performer = ".$row["id_performer"]."";
                      $result_perf = mysqli_query($link, $query_perf) or die("Ошибка " . mysqli_error($link));

                      $query_car ="SELECT * FROM cars WHERE id_performer = ".$row["id_performer"]."";
                      $result_car = mysqli_query($link, $query_car) or die("Ошибка " . mysqli_error($link));


                       print '
                       
                        <div class="tour-image">
                            <img class="big-photo-tour" src="'.$row["image"].'">
                            
                            <h1 class="title-tour">'.$row["title"].'</h1>
                            
                        </div>
                         
                        <article id="text-introduction">
                            <p>'.$row["description"].'</p><br>';
                            ?>
                            <script>
      //Определяется переменная, которая будет доступна для 
      // всех JavaScript, подключаемых на данной странице
      var cities = [<?php print $row["cities"]; ?>];
    </script>
    
    <script src="js/router.js" type="text/javascript"></script>
    
                            <div class="map-info">
                                <div id="map" style="width: 60%; height:300px"></div>

                            <?php
                            print '
                              <div>
                                <table>
                                  <tr>
                                    <td>Протяженность:</td><td>'.$row["length"].' км</td>
                                  </tr>
                                  <tr>
                                    <td>Количество дней: </td><td>'.$row["duration"].'</td>
                                  </tr>
                                </table>
                                <button class="button-order"><a href="order.php?id_tour='.$row["id_tour"].'">Оформить тур</a></button>
                              </div>
                            </div>';
                            
                      if(($result_perf) && ($result_car))
                          { 
                            print "<h3>Предлагаемые автомобили:</h3>";
                            while($row_car = mysqli_fetch_array($result_car)) { 
                               
                              print '<figure class="auto-fig">
                              <img class="photo-land" src="'.$row_car["image"].'">'.$span.'
                              <figcaption>
                                <h4>'.$row_car["mark"].'</h4>
                                <p>Модель: '.$row_car["model"].'</p>
                                <div class="info">Объем: '.$row_car["volume"].' л.</div>
                                <div class="info">Мощность: '.$row_car["power"].' л.с.</div>
                                </figcaption>
                            </figure>';
                            }

                             while($row_perf = mysqli_fetch_array($result_perf)) { 
                               
                               print '<h5> Ответственное лицо тура: '.$row_perf["name_performer"].'</h5>';
                             }
                             
                            }
                           
                            
                      }
                };
      ?>
</section>

  <?php
    include 'footer.php';
   ?>

     </body>
     <script type="text/javascript" src="js/slide.js"></script>
</html>
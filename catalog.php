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

    <?php
        require_once 'connection.php'; // подключаем скрипт
    
        // подключаемся к серверу
        $link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link));

        $search_q=$_GET['search_q'];
        
        if ($search_q) {
            $search_q = trim($search_q);
            $search_q = strip_tags($search_q);

            $q = mysqli_query($link, "SELECT * FROM `tours` WHERE title LIKE '%".$search_q."%'");
            while ($r_p = $q->fetch_assoc()) {
                $query = "SELECT * FROM `tours` WHERE id_tour = ".$r_p["id_tour"]."";
            }
        } else { 
            $query ="SELECT * FROM tours WHERE id_direction = ".$_GET["direction"]."";
            if (!$_GET["direction"]) 
                $query ="SELECT * FROM tours";
            
        } 
        
        
    
    ?>
    
     <section class="all-tours">
     
     <h1>Каталог поездок:</h1>
     <form method="get" action="catalog.php" style="width: 100%;">
            <div class="input-group mb-3">
                    <input type="text" class="search-inpt" name="search_q" placeholder="Поиск по наименованию тура">
                        <button class="search-btn" type="submit">Поиск</button>
                </div>
            </form>
    <?php
                // выполняем операции с базой данных
                
                $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
                if($result)
                { 
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
                    
                };
      ?>
  </section>
  <script>
    var user = <?php echo $_SESSION['id_cl']; ?>;
  function favoriteAdd(tour) {
        $.ajax({
            type: "POST",
            url: 'client/favorite_add.php',
            data: {id_tour : tour, id_user: user},
            success: function(response)
            {
                var jsonData = JSON.parse(response);
                if (jsonData.success == "1")
                {
                  alert('Тур добавлен в избранное!');

                }
                else
                {
                    alert('Что-то пошло не так!');
                }
           }
       });
     };

     function favoriteDel(tour) {
        $.ajax({
            type: "POST",
            url: 'client/favorite_del.php',
            data: {id_tour : tour, id_user: user},
            success: function(response)
            {
                var jsonData = JSON.parse(response);
                if (jsonData.success == "1")
                {
                  alert('Тур удален из избранного!');
                  //$('#em' + tour).hide();
                }
                else
                {
                    alert('Invalid Credentials!');
                }
           }
       });
     };
    </script>
  <?php
    include 'footer.php';
   ?>
   

     </body>
     <script type="text/javascript" src="js/slide.js"></script>
</html>
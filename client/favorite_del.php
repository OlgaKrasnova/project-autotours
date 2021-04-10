<?php require_once '../connection.php'; // подключаем скрипт
                
                  // подключаемся к серверу
                  $link = mysqli_connect($host, $user, $password, $database) 
                      or die("Ошибка " . mysqli_error($link));
                 
                 // если были переданы данные для добавления в БД
                 if(isset($_POST['id_user']) && isset($_POST['id_tour']))
                 {               
                 $sql_res_fav = mysqli_query($link, 'DELETE FROM `favorites` WHERE `id_tour` = "'.htmlspecialchars($_POST['id_tour']).'" AND `id_user` = "'.htmlspecialchars($_POST['id_user']).'"');
                      
                      echo json_encode(array('success' => 1));
                 } else {
                    echo json_encode(array('success' => 0));
                };
                
                      ?>